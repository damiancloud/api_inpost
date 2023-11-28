FROM php:8.1.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libmcrypt-dev\
    libpq-dev

RUN /bin/bash -c 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer'

WORKDIR /var/www

