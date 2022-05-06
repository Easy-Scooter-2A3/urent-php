FROM node:16 as builder-node

WORKDIR /app

COPY . .

RUN yarn install --production=false
RUN yarn production


FROM php:8.0-fpm as builder-php

EXPOSE 9000
WORKDIR /var/www

RUN apt update && apt install -y git curl libcurl4-openssl-dev libicu-dev

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql curl iconv intl

COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache


COPY --from=builder-node /app/public .

RUN chmod -R 755 /var/www
RUN chown -R www-data:www-data /var/www

USER www-data