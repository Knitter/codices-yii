FROM composer/composer:latest-bin AS composer

FROM ghcr.io/shyim/wolfi-php/frankenphp:8.4 AS base
ARG UID=10001
ARG GID=10001
RUN <<SH
    set -eo pipefail
    set -x

    # Add www-data group and user.
    addgroup -g 10001 -S www-data
    adduser -u 10001 -D -S -G www-data www-data

    # Set volume permissions.
    mkdir -p /data /config /app/runtime && \
    chown -R www-data:www-data /data /config /app/runtime

    # Install extra packages.
    apk add --no-cache \
    php-frankenphp-8.4-opcache \
    php-frankenphp-8.4-mbstring \
    php-frankenphp-8.4-intl \
    php-frankenphp-8.4-dom \
    php-frankenphp-8.4-curl \
    php-frankenphp-8.4-phar \
    php-frankenphp-8.4-openssl \
    php-frankenphp-8.4-xml \
    php-frankenphp-8.4-xmlwriter \
    php-frankenphp-8.4-simplexml \
    php-frankenphp-8.4-pdo
SH

FROM base AS prod-builder
COPY --from=composer /composer /usr/bin/composer

COPY ../app-master /app

RUN --mount=type=cache,target=/tmp/cache \
    <<SH
    set -eo pipefail
    set -x

    composer install --no-dev --no-progress --no-interaction --classmap-authoritative && \
    rm composer.lock composer.json
SH

FROM base AS prod
ENV YII_ENV=prod

COPY --from=prod-builder --chown=www-data:www-data /app /app
USER www-data

FROM base AS dev
RUN <<SH
    set -eo pipefail
    set -x

    # Install extra packages for dev only.
    apk add --no-cache \
    php-frankenphp-8.4-xdebug
SH

COPY --from=composer /composer /usr/bin/composer
USER www-data
