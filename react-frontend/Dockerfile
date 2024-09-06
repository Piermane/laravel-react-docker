FROM node:18-alpine

# Установка рабочей директории
WORKDIR /app

# Копирование package.json и package-lock.json
COPY package*.json ./

# Установка зависимостей
RUN npm ci

# Копирование файлов приложения
COPY . .

# Сборка приложения
RUN npm run build

# Открытие порта 3000
EXPOSE 3000

# Запуск приложения
CMD ["npm", "start"]
