FROM php:7.2-fpm-alpine

LABEL maintainer="Ryuta Hamasaki"

# ------------------------------------------------------------------------------
# Timezone
# ------------------------------------------------------------------------------

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# ------------------------------------------------------------------------------
# APP_ROOT, APP_USER
# ------------------------------------------------------------------------------

ENV APP_ROOT=/var/www/html \
    APP_USER=www-data

RUN set -ex \
  && mkdir -p "${APP_ROOT}" \
  && chown -R "${APP_USER}:${APP_USER}" "${APP_ROOT}"

# ------------------------------------------------------------------------------
# Composer
# ------------------------------------------------------------------------------

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN set -ex \
  && php -r "copy('https://raw.githubusercontent.com/composer/getcomposer.org/master/web/installer', 'composer-setup.php');" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer \
  && mkdir -p /home/www-data/.composer/cache \
  && chown -R "${APP_USER}:${APP_USER}" /home/www-data/.composer

# ------------------------------------------------------------------------------
# Node + Yarn
# ------------------------------------------------------------------------------

ENV APK_NODEJS_VERSION=10.16.3-r0 \
    APK_YARN_VERSION=1.16.0-r0

RUN set -ex \
  && apk add --no-cache \
    nodejs="${APK_NODEJS_VERSION}" \
    yarn="${APK_YARN_VERSION}" \
  && mkdir -p /home/www-data/.cache/yarn \
  && chown -R "${APP_USER}:${APP_USER}" /home/www-data/.cache/yarn

# ------------------------------------------------------------------------------
# PHP
# ------------------------------------------------------------------------------

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 \
    PHP_OPCACHE_SAVE_COMMENTS=1

RUN set -ex \
  && apk add --no-cache --virtual .php-deps \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    git \
  && git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
  && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
  && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
    intl \
    opcache \
    pdo_mysql \
    gd \
    zip \
    xml \
    redis

ENV XDEBUG_VERSION=2.7.0 \
    XDEBUG_REMOTE_ENABLE=0 \
    XDEBUG_REMOTE_HOST=docker.for.mac.localhost \
    XDEBUG_REMOTE_PORT=9000

RUN set -ex \
  && apk add --no-cache --virtual .php-xdebug-build-deps \
    autoconf \
    g++ \
    make \
  && pecl install "xdebug-${XDEBUG_VERSION}" \
  && docker-php-ext-enable xdebug \
  && apk del .php-xdebug-build-deps

COPY ./conf.d/*.ini /usr/local/etc/php/conf.d/
