FROM php:8.2-fpm

# Установка зависимостей PHP
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копирование файлов Laravel
COPY . .

# Установка прав и зависимостей
RUN composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data /var/www/html

# Настройка PHP-FPM
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000
CMD ["php-fpm"]
