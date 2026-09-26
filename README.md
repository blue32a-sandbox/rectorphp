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

既定値は `compose.yaml` にある。変えるときは `.env.example` を `.env` にコピーして編集し、`docker compose build --pull` する（`.env` は Git で追跡しない）。

Rector の変換先は、各シナリオの `composer.json` の `require.php` で決まる。`config.platform.php` も同じバージョンにそろえ、Composer がそのバージョンを基準に依存（Rector 自体も含む）を解決するようにする。

## シナリオ

- Rector は各シナリオの `require-dev` に入れる。ライブラリを使うシナリオでは `vendor/` の型情報やフレームワーク用の拡張ルールも使える
- `raw-*` シナリオのアプリコードは Composer の autoload を使わず、スクラッチのまま保つ（`vendor/` は Rector のためだけにある）
- `main` の各シナリオは常に出発点の状態に保ち、変換は `try/<name>-to-php<目標>` ブランチで行う
- `snapshots/` の記録はすべて体験用ブランチで作る（`main` では空）

| ファイル | 作る手順 | 内容 |
|---|---|---|
| `baseline.txt` | 3 | 出発点の PHP での出力 |
| `errors-before.txt` | 3 | 変換前のコードを目標の PHP で実行したときの Deprecated など（stderr） |
| `rector.txt` | 3 | `rector process --dry-run` の出力（差分と適用されたルール） |
| `target.txt` | 5 | 目標の PHP での出力（`baseline.txt` と比べる） |
| `errors-after.txt` | 5 | 目標の PHP で残った Deprecated やエラー（`errors-before.txt` と比べる） |

## 体験の手順

`raw-php84` を PHP 8.5 に上げる例。コマンドは PowerShell を想定する（Git Bash では `-w` のパスが変換されないよう `MSYS_NO_PATHCONV=1` を付ける）。

記録を保存するコマンドには `--progress quiet` を付け、`docker compose` 自身の表示（`Container ... Creating` など）が stderr に混ざらないようにする。

```powershell
$s = "scenarios/raw-php84"
```

### 0. 準備

```powershell
docker compose build --pull
docker compose run --rm -w /app/$s target composer install
```

### 1. 体験用ブランチを作る

```powershell
git switch -c try/raw-php84-to-php85
```

### 2. 目標を宣言する

`composer.json` の `require.php` を `~8.5.0`、`config.platform.php` を `8.5` に変え、依存を更新する。

```powershell
docker compose run --rm -w /app/$s target composer update
git add $s; git commit -m "build(raw-php84): 目標を PHP 8.5 に変更"
```

### 3. 変換前を記録する

```powershell
# 出発点の PHP での出力（Deprecated などは stderr に出して分ける）
docker compose --progress quiet run --rm source php -d display_errors=stderr $s/bin/run.php > $s/snapshots/baseline.txt

# 変換前のコードを目標の PHP で実行したときの Deprecated
docker compose --progress quiet run --rm target php -d display_errors=stderr $s/bin/run.php > $null 2> $s/snapshots/errors-before.txt

# Rector が何をするか（差分と適用されたルール）
docker compose --progress quiet run --rm -w /app/$s target vendor/bin/rector process --dry-run --no-progress-bar > $s/snapshots/rector.txt

git add $s; git commit -m "test(raw-php84): 変換前の出力と Rector の差分を記録"
```

`rector.txt` の差分とルール名を読み、`errors-before.txt` の Deprecated のどれが解消されそうかを見る。

### 4. Rector を適用する

```powershell
docker compose run --rm -w /app/$s target vendor/bin/rector process
git add $s; git commit -m "refactor(raw-php84): Rector (php85) を適用"
```

### 5. 変換後を記録する

```powershell
docker compose --progress quiet run --rm target php -d display_errors=stderr $s/bin/run.php > $s/snapshots/target.txt 2> $s/snapshots/errors-after.txt
git diff --no-index $s/snapshots/baseline.txt $s/snapshots/target.txt
git diff --no-index $s/snapshots/errors-before.txt $s/snapshots/errors-after.txt

git add $s; git commit -m "test(raw-php84): Rector 適用後の出力を記録"
```

`target.txt` が `baseline.txt` と一致し、`errors-after.txt` が空なら完了。

### 6. 手で直す

残った Deprecated やエラー、出力の差を手で直し、手順 5 の記録コマンドで記録を更新する。一致するまで繰り返す。

```powershell
git add $s; git commit -m "fix(raw-php84): Rector で直らない箇所を修正"
```

手順 5 と 6 のコミットを分けておくと、手で直したことで記録がどう変わったかを差分で確認できる。

### 7. 振り返る

```powershell
git log --oneline main..try/raw-php84-to-php85
git diff main try/raw-php84-to-php85 -- $s
```

依存の変化（`composer.lock`）、Rector の変更、手動の変更、記録の変化をコミット単位で確認できる。

### やり直す・別の目標で試す

- やり直す: `git switch main` → `git branch -D try/raw-php84-to-php85` → 手順 1 から
- 8.6 で試す: `.env` で `TARGET_PHP_VERSION=8.6` にして `docker compose build --pull target`、`try/raw-php84-to-php86` ブランチで手順 2 から
