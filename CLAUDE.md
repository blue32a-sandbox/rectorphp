# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 概要

Rector を使った PHP バージョンアップの学習用リポジトリ。`scenarios/` の各シナリオが「出発点の PHP で書かれたコード」で、それを目標の PHP に Rector と手作業で上げる体験をする。手順の詳細は [README.md](README.md#体験の手順)。

## コマンド

すべて Docker Compose 経由で、リポジトリのルートから実行する。

```powershell
docker compose build --pull                                                   # --pull なしだと古いベースイメージが使われることがある
docker compose run --rm -w /app/scenarios/<name> target composer install
docker compose run --rm source php -d display_errors=stderr scenarios/<name>/bin/run.php   # 出発点の PHP で実行
docker compose run --rm target php -d display_errors=stderr scenarios/<name>/bin/run.php   # 目標の PHP で実行（Deprecated は stderr）
docker compose run --rm -w /app/scenarios/<name> target vendor/bin/rector process --dry-run
```

Bash ツール（Git Bash）から `-w /app/...` を渡すとパスが Windows 形式に変換されて失敗するため、`MSYS_NO_PATHCONV=1` を付ける。

## 仕組み（複数ファイルにまたがる前提）

- **PHP の実行環境**: `compose.yaml` の `source` / `target` サービスが共通の `docker/php/Dockerfile` を `SOURCE_PHP_VERSION` / `TARGET_PHP_VERSION`（既定値は compose.yaml、上書きは git 管理外の `.env`）でビルドする。Rector は `target` で動かす。
- **Rector の変換先**: 各シナリオの `rector.php` は `withPhpSets()` を引数なしで呼び、カレントディレクトリ（= シナリオ）の `composer.json` の `require.php` から目標を読む。そのため Rector は必ず `-w /app/scenarios/<name>` で実行する。`config.platform.php` も同じバージョンにそろえ、依存（Rector 自体を含む）をそのバージョン基準で解決させる。
- **Rector の置き場所**: 共有ツールは持たず、各シナリオの `require-dev` に入れる。`raw-*` シナリオのアプリコードは autoload を使わずスクラッチのまま（`vendor/` は Rector のためだけ）。
- **`withPhpSets()` は目標までの全バージョンのルールを含む**。シナリオのコードは出発点のバージョンまでの書き方（例: 8.4 なら `readonly`、`match`）を済ませておかないと、古いバージョンのルールまで発火して題材がぼやける。

## シナリオの規約

- 名前は出発点だけを表す: `<種類><ライブラリのバージョン>-php<出発点>`（例: `raw-php84`, `laravel10-php81`）。目標のバージョンを名前に入れない。
- `main` のシナリオは常に出発点の状態に保つ。変換は `try/<name>-to-php<目標>` ブランチで行う。
- シナリオには Rector だけでは直らない箇所を意図的に含めている。`main` 上でそれらを「修正」しないこと。
- `snapshots/` の記録（`baseline.txt`、`errors-before.txt`、`rector.txt`、`target.txt`、`errors-after.txt`）は体験の一環として体験用ブランチで作る。`main` の `snapshots/` は空に保ち、記録をコミットしない。
- 記録を保存するときは `docker compose --progress quiet run ...` にする。付けないと `Container ... Creating` などの表示が stderr に混ざる。
- 作業ツリーの未コミットの変更は、ユーザーが体験中の成果物であることがある。触らない。

## コミット

Conventional Commits 形式。type/scope は英語、説明は日本語（例: `feat(scenarios): raw-php84 シナリオを追加`）。体験用ブランチでのコミットの type は README の手順に合わせる（`build` / `test` / `refactor` / `fix`）。
