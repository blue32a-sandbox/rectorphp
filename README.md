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

## 体験の手順

`raw-php84` を PHP 8.5 に上げる例。コマンドは PowerShell を想定する（Git Bash では `-w` のパスが変換されないよう `MSYS_NO_PATHCONV=1` を付ける）。

### 0. 準備

```powershell
docker compose build --pull
docker compose run --rm -w /app/scenarios/raw-php84 target composer install
```

### 1. 変換前の状態を記録する（`main`）

```powershell
# 出発点での出力を保存する（非推奨の警告は stderr に出して出力と分ける）
docker compose run --rm source php -d display_errors=stderr scenarios/raw-php84/bin/run.php > scenarios/raw-php84/snapshots/baseline.txt

# 変換前のコードを目標の PHP で実行し、出てくる Deprecated を確認する
docker compose run --rm target php -d display_errors=stderr scenarios/raw-php84/bin/run.php > $null
```

### 2. 体験用ブランチを作る

```powershell
git switch -c try/raw-php84-to-php85
```

### 3. 目標を宣言する

`composer.json` の `require.php` を `~8.5.0`、`config.platform.php` を `8.5` に変え、依存を更新する。

```powershell
docker compose run --rm -w /app/scenarios/raw-php84 target composer update
git commit -am "raw-php84: 目標を PHP 8.5 に変更"
```

### 4. Rector を試す

```powershell
docker compose run --rm -w /app/scenarios/raw-php84 target vendor/bin/rector process --dry-run
```

差分と適用されたルール名を読み、手順 1 で出た Deprecated のどれが解消されるかを見る。

### 5. Rector を適用する

```powershell
docker compose run --rm -w /app/scenarios/raw-php84 target vendor/bin/rector process
git commit -am "raw-php84: Rector (php85) を適用"
```

### 6. 目標の PHP で確認する

```powershell
docker compose run --rm target php -d display_errors=stderr scenarios/raw-php84/bin/run.php > scenarios/raw-php84/snapshots/target.txt
git diff --no-index scenarios/raw-php84/snapshots/baseline.txt scenarios/raw-php84/snapshots/target.txt
```

出力に差がなく、Deprecated が出なければ完了。

### 7. 手で直す

残った警告や出力の差を手で直し、手順 6 を繰り返す。

```powershell
git commit -am "raw-php84: 手動修正"
```

### 8. 振り返る

```powershell
git log --oneline main..try/raw-php84-to-php85
git diff main try/raw-php84-to-php85 -- scenarios/raw-php84
```

Rector の変更・手動の変更・依存の変化（`composer.lock`）をコミット単位で確認できる。

### やり直す・別の目標で試す

- やり直す: `git switch main` → `git branch -D try/raw-php84-to-php85` → 手順 2 から
- 8.6 で試す: `.env` で `TARGET_PHP_VERSION=8.6` にして `docker compose build --pull target`、`try/raw-php84-to-php86` ブランチで手順 3 から
