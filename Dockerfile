FROM php:7.4-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update
RUN apt-get install -y git zip zlib1g-dev libzip-dev zip librabbitmq-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && pecl install -o -f amqp \
    && docker-php-ext-enable amqp

RUN apt-get install -y mc