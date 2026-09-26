ARG PHP_VERSION
FROM php:${PHP_VERSION}-cli

# Composer がパッケージを展開・取得するためのツール
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ライブラリを使うシナリオで拡張が必要になったらここに追加する
