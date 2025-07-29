# 1️⃣ Use official PHP image with extensions
FROM php:8.3-fpm

# 2️⃣ Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libpng-dev libzip-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring exif pcntl bcmath gd

# 3️⃣ Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4️⃣ Set working directory
WORKDIR /var/www/html

# 5️⃣ Copy project files
COPY . .

# 6️⃣ Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Build frontend assets
RUN npm install && npm run build

# 8️⃣ Set permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# 9️⃣ Expose port
EXPOSE 8080

# 🔟 Start Laravel with PHP's built-in server
CMD php artisan serve --host=0.0.0.0 --port=8080
