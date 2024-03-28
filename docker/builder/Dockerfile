FROM composer:2.0.8 AS composer
FROM php:8.0.13-fpm-buster

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/builder/docker-setup.sh /usr/bin/

RUN /usr/bin/docker-setup.sh
