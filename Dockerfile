# Use official PHP 8.3 image with required extensions
FROM php:8.3-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    bash curl git unzip libpng-dev libjpeg-turbo-dev libwebp-dev libzip-dev postgresql-dev oniguruma-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN apk add --no-cache nodejs npm \
    && npm install \
    && npm run build \
    && rm -rf node_modules

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Generate optimized caches (except APP_KEY – must be set in Render)
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# Expose port
EXPOSE 8080

# Start Laravel server
CMD ["sh", "-c", "php artisan migrate --force && php artisan storage:link || true && php artisan serve --host=0.0.0.0 --port=8080"]
