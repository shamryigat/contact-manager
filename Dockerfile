# Use official PHP 8.3 image with required extensions
FROM php:8.3-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    bash curl git unzip libpng-dev libjpeg-turbo-dev libwebp-dev libzip-dev postgresql-dev oniguruma-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN apk add --no-cache nodejs npm \
    && npm install \
    && npm run build \
    && rm -rf node_modules

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Clear caches safely (won't fail if env is missing)
RUN if [ -f artisan ]; then \
    php artisan config:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true; \
fi

# Expose port
EXPOSE 8080

# Start Laravel server with migrations and storage link
CMD ["sh", "-c", "php artisan migrate --force && php artisan storage:link || true && php artisan serve --host=0.0.0.0 --port=8080"]
