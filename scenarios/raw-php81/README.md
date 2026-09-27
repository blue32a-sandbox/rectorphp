# raw-php81

ライブラリを使わず、PHP 8.1 で書かれたコード。PHP 8.1 までの書き方（`readonly` プロパティ、コンストラクタのプロパティ昇格、first-class callable など）は済んでいる前提。

題材は主に PHP 8.2 の変更。目標によっては複数のバージョンをまたぐ移行になる（例: PHP 8.5 が目標なら 8.2 から 8.5 の4つ）。

## 題材

| ファイル | 内容 |
|---|---|
| `src/classes.php` | `readonly` プロパティ、動的プロパティ、`"self::method"` 形式の callable |
| `src/strings.php` | 文字列への変数の埋め込み、`utf8_encode()` / `utf8_decode()`、`mb_convert_encoding()`、`str_split()` |
| `src/files.php` | `FilesystemIterator` |
| `src/arrays.php` | `ksort()` |

`bin/run.php` はすべての題材を実行し、結果を出力する。Rector だけでは移行が完了しない箇所も含まれている。

## 体験する

出発点の PHP は 8.1 なので、`.env` で `SOURCE_PHP_VERSION=8.1` にする。`TARGET_PHP_VERSION` は目標に合わせる（既定値は 8.5）。編集したら `docker compose build --pull` する。コマンドはリポジトリのルートで PowerShell から実行する。

[体験の手順](../../README.md#体験の手順)の変数は次のように設定する。`$to` は目標にする PHP で、ここでは 8.5 を例にする。

```powershell
$name = "raw-php81"
$to = "8.5"           # 目標の PHP（例）

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php81-to-php85
```

設定したら、出発点の PHP で動くことを確かめてから手順 0 に進む。

```powershell
docker compose run --rm -w /app/$s target composer install
docker compose run --rm source php -d display_errors=stderr $s/bin/run.php
```
