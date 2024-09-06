FROM php:8.1-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Инициализация Laravel проекта
RUN composer create-project --prefer-dist laravel/laravel .

# Копирование наших модифицированных файлов
COPY ./app/Http/Controllers/TaskController.php /var/www/app/Http/Controllers/
COPY ./routes/api.php /var/www/routes/

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
