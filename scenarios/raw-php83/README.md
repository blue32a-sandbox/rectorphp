# raw-php83

ライブラリを使わず、PHP 8.3 で書かれたコード。PHP 8.3 までの書き方（`readonly` クラス、コンストラクタのプロパティ昇格など）は済んでいる前提。

目標によっては複数のバージョンをまたぐ移行になる（例: PHP 8.5 が目標なら 8.4 と 8.5 の2つ）。

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

## 体験する

出発点の PHP は 8.3 なので、`.env` で `SOURCE_PHP_VERSION=8.3` にする。`TARGET_PHP_VERSION` は目標に合わせる（既定値は 8.5）。編集したら `docker compose build --pull` する。コマンドはリポジトリのルートで PowerShell から実行する。

[体験の手順](../../README.md#体験の手順)の変数は次のように設定する。`$to` は目標にする PHP で、ここでは 8.5 を例にする。

```powershell
$name = "raw-php83"
$to = "8.5"           # 目標の PHP（例）

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php83-to-php85
```

設定したら、出発点の PHP で動くことを確かめてから手順 0 に進む。

```powershell
docker compose run --rm -w /app/$s target composer install
docker compose run --rm source php -d display_errors=stderr $s/bin/run.php
```
