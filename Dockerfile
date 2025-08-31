FROM php:8.3-cli

# Instalacja systemowych paczek i rozszerzeń PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Instalacja Composera
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalacja Node.js + npm (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

COPY . .

CMD php artisan serve --host=0.0.0.0 --port=8000
