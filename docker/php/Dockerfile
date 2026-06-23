FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        mbstring \
        xml \
        intl \
        zip \
        pdo_mysql \
        fileinfo \
        curl \
        opcache \
        exif

RUN a2enmod rewrite

COPY php.ini /usr/local/etc/php/conf.d/concrete.ini
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
