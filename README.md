# Learning Rector

[Rector](https://github.com/rectorphp/rector) を使った PHP バージョンアップの学習用リポジトリ。

## 前提

- Docker（Docker Compose v2 の `docker compose` コマンド）

PHP と Composer はすべてコンテナの中で動かすので、手元に入れる必要はない。

## 構成

```
.
├── .env.example         # PHP バージョンを変えるときの見本（.env にコピーして使う）
├── compose.yaml         # source / target の2サービス
├── docker/php/          # PHP_VERSION で切り替える共通 Dockerfile
└── scenarios/           # 学習シナリオ（<種類>-php<出発点>、例: raw-php84, laravel10-php81）
    └── <name>/
        ├── README.md        # 題材と、体験の手順で使う値
        ├── composer.json    # require.php（出発点）+ require-dev に rector/rector
        ├── rector.php       # withPhpSets() を引数なしで呼ぶ
        ├── src/
        ├── bin/run.php
        └── snapshots/
```

## PHP のバージョン

| 変数 | サービス | 用途 |
|---|---|---|
| `SOURCE_PHP_VERSION` | `source` | 出発点のコードを実行する |
| `TARGET_PHP_VERSION` | `target` | 変換後のコードと Rector を実行する |

既定値は `compose.yaml` にある（`source` は 8.4、`target` は 8.5）。変えるときは `.env.example` を `.env` にコピーして編集し、`docker compose build --pull` する（`.env` は Git で追跡しない）。

`SOURCE_PHP_VERSION` はシナリオの出発点に、`TARGET_PHP_VERSION` は目標に合わせる（例: `raw-php83` を 8.5 に上げるなら `8.3` と `8.5`）。

Rector の変換先は、各シナリオの `composer.json` の `require.php` で決まる。`config.platform.php` も同じバージョンにそろえ、Composer がそのバージョンを基準に依存（Rector 自体も含む）を解決するようにする。

## シナリオ

| シナリオ | 出発点 | 内容 |
|---|---|---|
| [raw-php80](scenarios/raw-php80/README.md) | PHP 8.0 | ライブラリなし |
| [raw-php81](scenarios/raw-php81/README.md) | PHP 8.1 | ライブラリなし |
| [raw-php82](scenarios/raw-php82/README.md) | PHP 8.2 | ライブラリなし |
| [raw-php83](scenarios/raw-php83/README.md) | PHP 8.3 | ライブラリなし |
| [raw-php84](scenarios/raw-php84/README.md) | PHP 8.4 | ライブラリなし |

- Rector は各シナリオの `require-dev` に入れる。ライブラリを使うシナリオでは `vendor/` の型情報やフレームワーク用の拡張ルールも使える
- `raw-*` シナリオのアプリコードは Composer の autoload を使わず、スクラッチのまま保つ（`vendor/` は Rector のためだけにある）
- `main` の各シナリオは常に出発点の状態に保ち、変換は `try/<name>-to-php<目標>` ブランチで行う
- `snapshots/` の記録はすべて体験用ブランチで作る（`main` では空）

| ファイル | 作る手順 | 内容 |
|---|---|---|
| `baseline.txt` | 2 | 出発点の PHP での出力 |
| `errors-before.txt` | 2 | 変換前のコードを目標の PHP で実行したときの Deprecated など（stderr） |
| `rector.txt` | 4 | `rector process --dry-run` の出力（差分と適用されたルール） |
| `target.txt` | 6 | 目標の PHP での出力（`baseline.txt` と比べる） |
| `errors-after.txt` | 6 | 目標の PHP で残った Deprecated やエラー（`errors-before.txt` と比べる） |

## 体験の手順

[シナリオ](#シナリオ)を1つ選び、目標の PHP に上げる。コマンドは PowerShell を想定する（Git Bash では `-w` のパスが変換されないよう `MSYS_NO_PATHCONV=1` を付ける）。

記録を保存するコマンドには `--progress quiet` を付け、`docker compose` 自身の表示（`Container ... Creating` など）が stderr に混ざらないようにする。

最初に、シナリオと目標を変数に入れる。以降のコマンドはこの変数を使うので、どのシナリオでも書き換えずに実行できる。`$name` の値は各シナリオの README にある。`$to` には上げたい PHP のバージョンを入れる（最新とは限らない）。次の例は `raw-php84` を PHP 8.5 に上げる場合。

```powershell
$name = "raw-php84"   # シナリオ（scenarios/ の下のディレクトリ名）
$to = "8.5"           # 目標の PHP

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php84-to-php85
```

### 0. 準備

`.env` の `SOURCE_PHP_VERSION` をシナリオの出発点に、`TARGET_PHP_VERSION` を `$to` に合わせる（既定値と同じなら `.env` は要らない）。

```powershell
docker compose build --pull
docker compose run --rm -w /app/$s target composer install
```

### 1. 体験用ブランチを作る

```powershell
git switch -c $branch
```

### 2. 変換前を記録する

何も変えないうちに、出発点のコードの振る舞いを記録する。

```powershell
# 出発点の PHP での出力（Deprecated などは stderr に出して分ける）
docker compose --progress quiet run --rm source php -d display_errors=stderr $s/bin/run.php > $s/snapshots/baseline.txt

# 変換前のコードを目標の PHP で実行したときの Deprecated
docker compose --progress quiet run --rm target php -d display_errors=stderr $s/bin/run.php > $null 2> $s/snapshots/errors-before.txt

git add $s; git commit -m "test($name): 変換前の出力を記録"
```

### 3. 目標を宣言する

`$s/composer.json` の `require.php` を `~$to.0`（例: `~8.5.0`）、`config.platform.php` を `$to`（例: `8.5`）に変え、依存を更新する。

```powershell
docker compose run --rm -w /app/$s target composer update
git add $s; git commit -m "build($name): 目標を PHP $to に変更"
```

### 4. Rector の変更を確かめる

Rector の変換先は `require.php` から決まるので、目標を宣言したあとに dry-run する。

```powershell
# Rector が何をするか（差分と適用されたルール）
docker compose --progress quiet run --rm -w /app/$s target vendor/bin/rector process --dry-run --no-progress-bar > $s/snapshots/rector.txt

git add $s; git commit -m "test($name): Rector の差分を記録"
```

`rector.txt` の差分とルール名を読み、`errors-before.txt` の Deprecated のどれが解消されそうかを見る。

### 5. Rector を適用する

```powershell
docker compose run --rm -w /app/$s target vendor/bin/rector process
git add $s; git commit -m "refactor($name): Rector (PHP $to) を適用"
```

### 6. 変換後を記録する

```powershell
docker compose --progress quiet run --rm target php -d display_errors=stderr $s/bin/run.php > $s/snapshots/target.txt 2> $s/snapshots/errors-after.txt
git diff --no-index $s/snapshots/baseline.txt $s/snapshots/target.txt
git diff --no-index $s/snapshots/errors-before.txt $s/snapshots/errors-after.txt

git add $s; git commit -m "test($name): Rector 適用後の出力を記録"
```

`target.txt` が `baseline.txt` と一致し、`errors-after.txt` が空なら完了。

### 7. 手で直す

残った Deprecated やエラー、出力の差を手で直し、手順 6 の記録コマンドで記録を更新する。一致するまで繰り返す。

```powershell
git add $s; git commit -m "fix($name): Rector で直らない箇所を修正"
```

手順 6 と 7 のコミットを分けておくと、手で直したことで記録がどう変わったかを差分で確認できる。

### 8. 振り返る

```powershell
git log --oneline main..$branch
git diff main $branch -- $s
```

依存の変化（`composer.lock`）、Rector の変更、手動の変更、記録の変化をコミット単位で確認できる。

### やり直す・別の目標で試す

- やり直す: `git switch main` → `git branch -D $branch` → 手順 1 から
- 別の目標で試す（例: 8.6）: `.env` で `TARGET_PHP_VERSION=8.6` にして `docker compose build --pull target`、`git switch main` してから `$to = "8.6"` で変数を設定し直し、手順 1 から
