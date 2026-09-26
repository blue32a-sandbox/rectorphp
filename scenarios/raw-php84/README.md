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

## 実行

リポジトリのルートで実行する。

```powershell
docker compose run --rm -w /app/scenarios/raw-php84 target composer install
docker compose run --rm source php -d display_errors=stderr scenarios/raw-php84/bin/run.php
```

体験の手順はリポジトリの [README](../../README.md#体験の手順) を参照。
