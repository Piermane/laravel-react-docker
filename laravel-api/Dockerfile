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

# Установка PHP расширений
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копирование файлов проекта
WORKDIR /var/www/html
COPY . /var/www/html

# Установка зависимостей
RUN if [ -f "composer.json" ]; then \
        composer install --no-interaction --prefer-dist --optimize-autoloader; \
    else \
        rm -rf * .[!.]* ..?* && \
        composer create-project --prefer-dist laravel/laravel . && \
        composer install --no-interaction --prefer-dist --optimize-autoloader; \
    fi

# Установка прав доступа
RUN chown -R www-data:www-data storage bootstrap/cache

# Открытие порта 9000 и запуск php-fpm сервера и artisan serve
EXPOSE 9000

# Запуск двух процессов
CMD php-fpm & php artisan serve --host=0.0.0.0 --port=8000
