FROM node:18-alpine

# Установка рабочей директории
WORKDIR /app

# Копирование файлов проекта
COPY ./react-frontend .

# Проверка наличия package.json и установка зависимостей
RUN if [ -f package.json ]; then \
        npm install; \
        if grep -q '"build"' package.json; then \
            npm run build; \
        fi; \
    else \
        echo "package.json not found. Skipping npm install and build."; \
    fi

# Открытие порта 3000
EXPOSE 3000

# Запуск приложения или вывод сообщения об ошибке
CMD if [ -f package.json ]; then \
        if grep -q '"start"' package.json; then \
            npm start; \
        else \
            echo "No start script found in package.json"; \
            exit 1; \
        fi; \
    else \
        echo "No package.json found. Cannot start the application."; \
        exit 1; \
    fi
