FROM composer:2.0.8 AS composer
FROM php:8.0.13-fpm-buster

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/app/docker-setup.sh /usr/bin/
RUN /usr/bin/docker-setup.sh

RUN mkdir /var/run/temp && \
    chown www-data:www-data /var/run/temp /usr/local/openresty/nginx/logs

COPY --chown=www-data:www-data ./ /var/www/lecture
COPY --chown=www-data:www-data ./config/nginx /usr/local/openresty/nginx/conf
COPY config/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY --chown=www-data:www-data ./config/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY --chown=www-data:www-data ./config/php/php.ini /usr/local/etc/php/php.ini
COPY --chown=www-data:www-data ./config/php/php.ini /usr/local/etc/php/php.ini-development

WORKDIR /var/www/lecture
ENTRYPOINT ["/var/www/lecture/bin/docker-entrypoint"]
