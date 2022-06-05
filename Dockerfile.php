FROM php:8.1-fpm-alpine

EXPOSE 9000
WORKDIR /var/www

RUN apk add --no-cache git curl curl-dev icu-dev

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql curl intl
RUN apk del curl-dev icu-dev

COPY . .
RUN composer install --optimize-autoloader --no-interaction --no-dev

RUN php artisan config:clear
# && php artisan config:cache
RUN php artisan route:clear
# && php artisan route:cache
RUN php artisan view:clear
# && php artisan view:cache

RUN chmod -R 755 /var/www
RUN chown -R www-data:www-data /var/www

# clean
RUN rm -rf /var/cache/apk/* && rm -rf \
    yarn.lock \
    webpack.mix.js \
    tsconfig.json \
    package.json \
    docker \
    database \
    html \
    tests \
    tailwind.config.js \
    phpunit.xml \
    composer*


RUN chmod +x run.sh && cp run.sh /usr/local/bin/run

USER www-data

CMD [ "run" ]