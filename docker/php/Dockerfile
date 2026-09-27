ARG PHP_VERSION
FROM php:${PHP_VERSION}-cli

# Composer がパッケージを展開・取得するためのツール
#
# サポートが終わった Debian（PHP 8.0 の bullseye など）では、セキュリティ更新のパッケージを
# 取得できなくなることがある。そのときはセキュリティ更新を使わない設定を加えて入れ直す。
# この設定はイメージに残るので、以降の apt-get（拡張のためのライブラリなど）にも効く
RUN apt-get update \
    && { apt-get install -y --no-install-recommends git unzip \
        || { printf 'Package: *\nPin: release l=Debian-Security\nPin-Priority: -1\n' > /etc/apt/preferences.d/no-security-updates \
            && apt-get install -y --no-install-recommends git unzip; }; } \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ライブラリを使うシナリオで拡張が必要になったらここに追加する
