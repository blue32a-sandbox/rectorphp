# raw-php80

ライブラリを使わず、PHP 8.0 で書かれたコード。PHP 8.0 までの書き方（コンストラクタのプロパティ昇格、型付きプロパティ、アロー関数など）は済んでいる前提。

題材は主に PHP 8.1 の変更。目標によっては複数のバージョンをまたぐ移行になる（例: PHP 8.5 が目標なら 8.1 から 8.5 の5つ）。

## 題材

| ファイル | 内容 |
|---|---|
| `src/classes.php` | コンストラクタで受け取るプロパティ、メソッド内の `static` 変数 |
| `src/collection.php` | `ArrayAccess` などの組み込みインターフェース、`Serializable` |
| `src/callables.php` | 配列形式の callable、`Closure::fromCallable()`、`ReflectionProperty::setAccessible()` |
| `src/strings.php` | `htmlspecialchars()`、`FILTER_SANITIZE_STRING`、`strftime()` |
| `src/conversions.php` | float の配列キー、`false` への `[]` |

`bin/run.php` はすべての題材を実行し、結果を出力する。Rector だけでは移行が完了しない箇所も含まれている。

## 体験する

出発点の PHP は 8.0 なので、`.env` で `SOURCE_PHP_VERSION=8.0` にする。`TARGET_PHP_VERSION` は目標に合わせる（既定値は 8.5）。編集したら `docker compose build --pull` する。コマンドはリポジトリのルートで PowerShell から実行する。

[体験の手順](../../README.md#体験の手順)の変数は次のように設定する。`$to` は目標にする PHP で、ここでは 8.5 を例にする。

```powershell
$name = "raw-php80"
$to = "8.5"           # 目標の PHP（例）

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php80-to-php85
```

設定したら、出発点の PHP で動くことを確かめてから手順 0 に進む。

```powershell
docker compose run --rm -w /app/$s target composer install
docker compose run --rm source php -d display_errors=stderr $s/bin/run.php
```
