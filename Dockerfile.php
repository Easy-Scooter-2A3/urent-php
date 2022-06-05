FROM node:16-slim as builder-node

WORKDIR /app

COPY . .

RUN yarn install --production=false
RUN yarn production


FROM php:8.1-fpm-alpine as builder-php

EXPOSE 9000
WORKDIR /var/www

RUN apk add --no-cache git curl curl-dev icu-dev
RUN apk del curl-dev icu-dev

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql curl intl

COPY . .
RUN composer install --optimize-autoloader --no-interaction --no-dev

RUN php artisan config:clear
# && php artisan config:cache
RUN php artisan route:clear
# && php artisan route:cache
RUN php artisan view:clear
# && php artisan view:cache


COPY --from=builder-node /app/public .

RUN chmod -R 755 /var/www
RUN chown -R www-data:www-data /var/www

USER www-data