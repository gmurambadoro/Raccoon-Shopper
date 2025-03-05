FROM php:8.3-apache

WORKDIR /var/www/html

# install dependencies
RUN apt-get update \
    && apt-get install -y curl apt-transport-https ca-certificates gnupg \
    && apt-get update \
    && apt-get install -y git zip libicu-dev zlib1g-dev g++ libpng-dev

# install php extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath \
    && docker-php-ext-configure intl && docker-php-ext-install intl

RUN docker-php-ext-install gd

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# enable apache2 modules
RUN a2enmod rewrite
