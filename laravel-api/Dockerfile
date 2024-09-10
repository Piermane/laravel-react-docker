FROM php:8.2-fpm-alpine

# Установка зависимостей и расширений PHP
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html

# Копирование файлов проекта
COPY . .

# Установка зависимостей и оптимизация автозагрузки
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html

# Копирование конфигурации PHP-FPM
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

CMD ["php-fpm"]
