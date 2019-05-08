#!/bin/bash
set -e

env >> /var/www/.env
php-fpm7.2 -D
cd /var/www
php artisan migrate:fresh --seed --force
nginx -g "daemon off;"
