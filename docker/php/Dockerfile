FROM php:7.3-fpm

RUN apt-get update \
    && apt-get install -y libicu-dev libzip-dev zip git g++ \
    && docker-php-ext-install intl zip pdo pdo_mysql