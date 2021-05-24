FROM registry.hub.docker.com/library/php:7.4-fpm-alpine AS base

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

FROM base AS composer

RUN apk --no-cache update && \
    apk add git unzip libzip-dev && \
    docker-php-ext-install zip

WORKDIR /composer

COPY ./composer.json ./
COPY ./composer.lock ./
COPY ./src ./

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv /composer/composer.phar /usr/local/bin/composer
RUN composer install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist \
    --classmap-authoritative \
    --no-scripts \
    --no-suggest \
    --no-progress \
    --quiet

FROM composer AS dev

ENV APP_ENV dev
ENV APP_DEBUG 1

WORKDIR /var/www/psr-portfolio

COPY ./composer.json ./
COPY ./composer.lock ./

RUN composer install \
    --no-interaction \
    --no-scripts \
    --no-suggest \
    --no-progress \
    --quiet

# TODO: Install xdebug

FROM base AS prod

ENV APP_ENV prod
ENV APP_DEBUG 0

WORKDIR /var/www/psr-portfolio

COPY ./config ./
COPY ./src ./
COPY ./public/index.php ./public/
COPY ./templates ./
COPY ./data ./
COPY --from=composer /composer/vendor ./

RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
