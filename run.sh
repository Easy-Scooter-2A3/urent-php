#!/usr/bin/env sh
php artisan config:cache
php artisan route:cache
php artisan view:cache
rm artisan

exec php-fpm