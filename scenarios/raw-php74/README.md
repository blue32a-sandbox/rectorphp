# raw-php74

ライブラリを使わず、PHP 7.4 で書かれたコード。PHP 7.4 までの書き方（型付きプロパティ、アロー関数など）は済んでいる前提。

題材は主に PHP 8.0 の変更。メジャーバージョンをまたぐので、Deprecated を出さずに結果が変わる箇所が多い。目標によっては複数のバージョンをまたぐ移行になる（例: PHP 8.5 が目標なら 8.0 から 8.5 の6つ）。

## 題材

| ファイル | 内容 |
|---|---|
| `src/classes.php` | コンストラクタでのプロパティの代入、`__toString()`、`private final` |
| `src/strings.php` | `strpos()` / `substr()` での判定、`is_numeric()` |
| `src/comparisons.php` | 文字列と数値の比較（`switch`、`==`、`in_array()`） |
| `src/sorting.php` | `usort()`、`sort()` |
| `src/types.php` | 値の型名、`ReflectionParameter::getClass()` |
| `src/runtime.php` | curl のハンドル、例外、`libxml_disable_entity_loader()` |

`bin/run.php` はすべての題材を実行し、結果を出力する。Rector だけでは移行が完了しない箇所も含まれている。

## 体験する

出発点の PHP は 7.4 なので、`.env` で `SOURCE_PHP_VERSION=7.4` にする。`TARGET_PHP_VERSION` は目標に合わせる（既定値は 8.5）。編集したら `docker compose build --pull` する。コマンドはリポジトリのルートで PowerShell から実行する。

[体験の手順](../../README.md#体験の手順)の変数は次のように設定する。`$to` は目標にする PHP で、ここでは 8.5 を例にする。

```powershell
$name = "raw-php74"
$to = "8.5"           # 目標の PHP（例）

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php74-to-php85
```

設定したら、出発点の PHP で動くことを確かめてから手順 0 に進む。

```powershell
docker compose run --rm -w /app/$s target composer install
docker compose run --rm source php -d display_errors=stderr $s/bin/run.php
```
