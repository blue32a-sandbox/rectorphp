# raw-php73

ライブラリを使わず、PHP 7.3 で書かれたコード。PHP 7.3 までの書き方（`??`、スカラー型と戻り値の型の宣言など）は済んでいる前提。

題材は主に PHP 7.4 の変更。PHP 8.0 で削除された構文を含むので、変換前のコードは PHP 8 以降では構文エラーになり、実行できない。目標によっては複数のバージョンをまたぐ移行になる（例: PHP 8.5 が目標なら 7.4 から 8.5 の7つ）。

Rector 2 は PHP 7.4 以上を必要とするため、`composer.json` では `rector/rector` を `^1.2 || ^2.0` にしている。出発点の PHP 7.3 では Rector 1 が入り、目標を宣言して `composer update` すると Rector 2 に上がる。

## 題材

| ファイル | 内容 |
|---|---|
| `src/syntax.php` | 三項演算子の入れ子、波括弧による文字列オフセット、`(real)`、`.` と `+` の混在 |
| `src/functions.php` | `array_key_exists()`、`money_format()`、`FILTER_SANITIZE_MAGIC_QUOTES`、`mb_strrpos()` |
| `src/closures.php` | クロージャ、`??` による代入 |
| `src/conversions.php` | `hexdec()`、`false` の配列としての参照、パスワードのアルゴリズム |

`bin/run.php` はすべての題材を実行し、結果を出力する。Rector だけでは移行が完了しない箇所も含まれている。

## 体験する

出発点の PHP は 7.3 なので、`.env` で `SOURCE_PHP_VERSION=7.3` にする。`TARGET_PHP_VERSION` は目標に合わせる（既定値は 8.5）。編集したら `docker compose build --pull` する。コマンドはリポジトリのルートで PowerShell から実行する。

[体験の手順](../../README.md#体験の手順)の変数は次のように設定する。`$to` は目標にする PHP で、ここでは 8.5 を例にする。

```powershell
$name = "raw-php73"
$to = "8.5"           # 目標の PHP（例）

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php73-to-php85
```

設定したら、出発点の PHP で動くことを確かめてから手順 0 に進む。

```powershell
docker compose run --rm -w /app/$s target composer install
docker compose run --rm source php -d display_errors=stderr $s/bin/run.php
```
