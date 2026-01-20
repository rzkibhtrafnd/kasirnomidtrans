FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Permissions (WAJIB)
RUN chmod -R 775 storage bootstrap/cache

# PHP deps
RUN composer install --no-dev --optimize-autoloader

# Node + build
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

EXPOSE 8080

# MIGRATE TIDAK BOLEH MEMBUNUH SERVER
CMD php artisan migrate --force || true && php artisan serve --host=0.0.0.0 --port=8080
