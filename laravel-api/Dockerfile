FROM php:8.2-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Очистка кеша
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Получение последней версии Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www/html

# Копирование composer.json и composer.lock (если есть)
COPY composer*.json composer*.lock ./

# Установка зависимостей
RUN composer install --no-scripts --no-autoloader

# Копирование остальных файлов проекта
COPY . .

# Генерация автозагрузчика и выполнение скриптов
RUN composer dump-autoload --optimize && composer run-script post-autoload-dump

# Установка прав доступа
RUN chown -R www-data:www-data storage bootstrap/cache

# Открытие порта 9000 и запуск php-fpm сервера
EXPOSE 9000
CMD ["php-fpm"]
