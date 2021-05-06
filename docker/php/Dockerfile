FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wkhtmltopdf xvfb

RUN set -ex; \
        apt-get update && apt-get install -y --no-install-recommends \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libpq-dev	\
        librabbitmq-dev \
        zip; \
    apt-get update; \
    docker-php-ext-install pgsql pdo_pgsql && docker-php-ext-enable pgsql  pdo_pgsql; \ && docker-php-ext-enable zip; \
    curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

VOLUME php.ini:/usr/local/etc/php/php.ini-development
WORKDIR  /var/www/backend

