FROM php:7-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libicu-dev \
        libssl-dev \
                --no-install-recommends

# Install Composer globally
RUN curl -s -o /usr/local/bin/composer https://getcomposer.org/composer.phar  \
    && chmod 0755 /usr/local/bin/composer

RUN docker-php-ext-install mcrypt zip intl mbstring exif \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

RUN pecl install mongodb \
    && echo extension=mongodb.so > /usr/local/etc/php/conf.d/ext-mongodb.ini

RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN usermod -u 1000 www-data

EXPOSE 9000
CMD ["php-fpm"]