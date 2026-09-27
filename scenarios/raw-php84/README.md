# raw-php84

ライブラリを使わず、PHP 8.4 で書かれたコード。PHP 8.4 までの書き方（`readonly`、コンストラクタのプロパティ昇格など）は済んでいる前提。

## 題材

| ファイル | 内容 |
|---|---|
| `src/casts.php` | `(integer)` などの型キャスト |
| `src/syntax.php` | `switch` の書き方、バッククォート演算子 |
| `src/strings.php` | `ord()` / `chr()` に渡す値 |
| `src/arrays.php` | 配列の最初・最後の要素、`null` をキーに使う書き方 |
| `src/serialization.php` | `__sleep()` / `__wakeup()`、`__debugInfo()` |
| `src/extensions.php` | `SplObjectStorage`、fileinfo、xml、curl、filter |

`bin/run.php` はすべての題材を実行し、結果を出力する。Rector だけでは移行が完了しない箇所も含まれている。

## 体験する

出発点の PHP 8.4 と目標の PHP 8.5 は `compose.yaml` の既定値なので、`.env` は要らない。コマンドはリポジトリのルートで PowerShell から実行する。

[体験の手順](../../README.md#体験の手順)の変数は次のように設定する。

```powershell
$name = "raw-php84"
$to = "8.5"

$s = "scenarios/$name"
$branch = "try/$name-to-php$($to.Replace('.', ''))"   # try/raw-php84-to-php85
```

設定したら、出発点の PHP で動くことを確かめてから手順 0 に進む。

```powershell
docker compose run --rm -w /app/$s target composer install
docker compose run --rm source php -d display_errors=stderr $s/bin/run.php
```
