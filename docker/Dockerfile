FROM php:7.4.1-apache

#OPCACHE
RUN docker-php-ext-install opcache

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

###COMPOSER###
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN apt-get update \
    && apt-get install -y zip unzip libzip-dev

RUN docker-php-ext-install zip

###FIN COMPOSER###

#XDEBUG
RUN pecl install xdebug
#Activar sólo para debug, cuando no se vaya a usar dejar desactivado
#RUN docker-php-ext-enable xdebug
RUN echo 'xdebug.remote_port=9000\n\
    xdebug.remote_enable=1\n\
    xdebug.remote_connect_back=1\n\
    xdebug.profiler_enable_trigger=1\n\
    xdebug.profiler_output_dir=/var/www/html\n\
    xdebug.idekey = PHPSTORM\n\
    xdebug.remote_autostart=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

###FIN XDEBUG###

RUN apt-get -y install sudo

RUN useradd -u 1000 docker \
    && adduser docker sudo \
    && adduser docker root \
    && echo "docker ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers

USER 1000:1000

CMD sudo apache2-foreground