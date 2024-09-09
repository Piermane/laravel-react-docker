FROM php:8.2-fpm

# Установка системных зависимостей и PHP расширений
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html

# Копирование файлов проекта
COPY . .

# Установка зависимостей и базовая настройка Laravel
RUN if [ -f "composer.json" ]; then \
        composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader; \
        if [ -f "artisan" ]; then \
            php artisan key:generate --force; \
            php artisan config:cache; \
            php artisan route:cache; \
            php artisan view:cache; \
        fi \
    fi

# Установка прав доступа
RUN chown -R www-data:www-data .

# Настройка PHP-FPM
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

CMD ["php-fpm"]
