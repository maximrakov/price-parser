FROM php:8.1-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libonig-dev \
        libicu-dev \
        libpq-dev \
        libmcrypt-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libssl-dev \
        libcurl4-openssl-dev \
        pkg-config \
        && docker-php-ext-install pdo pdo_pgsql

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

RUN apt-get install -y npm
RUN apt-get install -y nodejs
