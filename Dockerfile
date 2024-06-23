FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    wget \
    && docker-php-ext-install pdo_mysql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

CMD ["php", "-S", "0.0.0.0:9000", "app.php"]
