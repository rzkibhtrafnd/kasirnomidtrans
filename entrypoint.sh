#!/bin/sh
set -e

php artisan migrate --force || true

exec php artisan serve --host=0.0.0.0 --port=8080
