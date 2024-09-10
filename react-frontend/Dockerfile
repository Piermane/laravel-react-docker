FROM node:18-alpine AS builder
WORKDIR /app

# Копирование файлов package.json и package-lock.json (если есть)
COPY package*.json ./

# Установка зависимостей
RUN npm ci

# Копирование остальных файлов проекта
COPY . .

# Сборка проекта
RUN npm run build

# Финальный этап
FROM nginx:alpine
COPY --from=builder /app/build /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
