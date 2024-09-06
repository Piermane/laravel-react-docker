FROM node:18-alpine

# Установка рабочей директории
WORKDIR /app

# Копируем все файлы проекта, включая package.json и папку src
COPY ./react-frontend /app

# Устанавливаем зависимости и собираем проект
RUN if [ -f package.json ]; then \
        npm install && npm run build; \
    else \
        echo "package.json не найден. Пропускаем установку."; \
    fi

# Открываем порт и запускаем приложение
EXPOSE 3000
CMD ["npm", "start"]
