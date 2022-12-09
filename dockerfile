FROM php:8-fpm

RUN apt update -y \
    && apt-get install -y nginx zip unzip

ENV PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install opcache \
    && apt-get install libicu-dev -y \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get remove libicu-dev icu-devtools -y \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongo.ini

RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=4000'; \
        echo 'opcache.revalidate_freq=2'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/php-opocache-cfg.ini

COPY nginx-site.conf /etc/nginx/sites-enabled/default
COPY entrypoint.sh /etc/entrypoint.sh

COPY --chown=www-data:www-data . /var/www/ratemynugget

WORKDIR /var/www/ratemynugget
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer require mongodb/mongodb
RUN composer install

EXPOSE 8080

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]