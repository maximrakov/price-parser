FROM php:8.1-fpm

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
        && docker-php-ext-install pdo_mysql zip mbstring intl bcmath mysqli gd curl sockets exif opcache

RUN apt-get install -y supervisor && mkdir -p /var/log/supervisor

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN apt-get install -y curl
RUN apt-get install -y npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash
RUN apt-get install -y nodejs

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

RUN composer install
RUN npm run build
EXPOSE 8000
CMD sh /var/www/html/docker/entrypoint.sh

