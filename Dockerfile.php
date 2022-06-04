FROM node:16 as builder-node

WORKDIR /app

COPY . .

RUN yarn install --production=false
RUN yarn production


FROM php:8.1-fpm as builder-php

EXPOSE 9000
WORKDIR /var/www

RUN apt update && apt install -y git curl libcurl4-openssl-dev libicu-dev

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql curl iconv intl

COPY . .
RUN composer install --optimize-autoloader --no-interaction --no-dev

RUN pecl install redis

RUN docker-php-ext-enable redis

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