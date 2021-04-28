FROM registry.hub.docker.com/library/php:7.4-fpm-alpine AS base

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

FROM base AS composer

RUN apk --no-cache update && \
    apk add git unzip libzip-dev && \
    docker-php-ext-install zip

COPY ./composer.json /composer/composer.json
COPY ./composer.lock /composer/composer.lock

WORKDIR /composer

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN php composer.phar install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist \
    --classmap-authoritative \
    --no-scripts \
    --no-suggest \
    --no-progress \
    --quiet

COPY ./src /composer/src
RUN php composer.phar dump-autoload  \
    --no-interaction \
    --no-dev \
    --optimize \
    --classmap-authoritative \
    --no-scripts \
    --quiet

FROM composer AS dev

ENV APP_ENV dev
ENV APP_DEBUG 1

# install xdebug

FROM base AS prod

ENV APP_ENV prod
ENV APP_DEBUG 0

COPY ./config /var/psr-portfolio/config
COPY ./src /var/psr-portfolio/src
COPY ./public/index.php /var/psr-portfolio/public/index.php
COPY ./templates /var/psr-portfolio/templates
COPY ./data /var/psr-portfolio/data
COPY --from=composer /composer/vendor /var/psr-portfolio/vendor

RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
