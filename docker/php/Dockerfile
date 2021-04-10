FROM registry.hub.docker.com/library/php:7.4-fpm-alpine AS base

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

FROM base

COPY ./config /var/psr-portfolio/config
COPY ./src /var/psr-portfolio/src
COPY ./public/index.php /var/psr-portfolio/public/index.php
COPY ./templates /var/psr-portfolio/templates
COPY --from=composer /composer/vendor /var/psr-portfolio/vendor
