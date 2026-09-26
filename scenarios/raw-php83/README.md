# raw-php83

ライブラリを使わず、PHP 8.3 で書かれたコード。PHP 8.3 までの書き方（`readonly` クラス、コンストラクタのプロパティ昇格など）は済んでいる前提。

目標を PHP 8.5 にすると、PHP 8.4 と 8.5 の2つのバージョンをまたぐ移行になる。

## 題材

| ファイル | 内容 |
|---|---|
| `src/nullable.php` | 引数の型とデフォルト値、`new` 式のメソッド呼び出し |
| `src/csv.php` | `fputcsv()` / `str_getcsv()` |
| `src/rounding.php` | `round()` の丸めモード |
| `src/collections.php` | foreach による配列の検索 |
| `src/errors.php` | `E_STRICT`、`trigger_error()`、`lcg_value()` |
| `src/casts.php` | 型キャスト、`curl_close()` |

`bin/run.php` はすべての題材を実行し、結果を出力する。Rector だけでは移行が完了しない箇所も含まれている。

## 実行

出発点の PHP は 8.3 なので、`.env` で `SOURCE_PHP_VERSION=8.3` にしてから `docker compose build --pull source` する。コマンドはリポジトリのルートで実行する。

```powershell
docker compose run --rm -w /app/scenarios/raw-php83 target composer install
docker compose run --rm source php -d display_errors=stderr scenarios/raw-php83/bin/run.php
```

体験の手順はリポジトリの [README](../../README.md#体験の手順) を参照（`raw-php84` を `raw-php83` に読み替える）。
