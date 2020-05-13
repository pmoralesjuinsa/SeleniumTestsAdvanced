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
RUN echo 'xdebug.remote_port=9000\n\
    xdebug.remote_enable=1\n\
    xdebug.remote_connect_back=1\n\
    xdebug.profiler_enable_trigger=1\n\
    xdebug.profiler_output_dir=/var/www/html\n\
    xdebug.idekey = PHPSTORM\n\
    xdebug.remote_autostart=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

###FIN XDEBUG###

RUN apt-get -y install sudo

#MAIL FUNCITON
#RUN apt-get install ssmtp
## set recommended PHP.ini settings
## see https://secure.php.net/manual/en/opcache.installation.php
#RUN { \
#                echo 'opcache.memory_consumption=128'; \
#                echo 'opcache.interned_strings_buffer=8'; \
#                echo 'opcache.max_accelerated_files=4000'; \
#                echo 'opcache.revalidate_freq=2'; \
#                echo 'opcache.fast_shutdown=1'; \
#                echo 'opcache.enable_cli=1'; \
#        } &gt; /usr/local/etc/php/conf.d/opcache-recommended.ini
## and adding a php.ini with the senmail path to ssmtp
#RUN echo 'sendmail_path = /usr/sbin/ssmtp -t' &gt;&gt; /usr/local/etc/php/php.ini
## now copy the local ssmtp.conf file
#COPY ssmtp.conf /etc/ssmtp/ssmtp.conf
#
## Apache Module aktivieren
#RUN a2enmod rewrite expires
#END MAIL FUNCTION

RUN useradd -u 1000 docker \
    && adduser docker sudo \
    && adduser docker root \
    && echo "docker ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers

USER 1000:1000

#Activar sólo para debug, cuando no se vaya a usar dejar desactivado
#RUN docker-php-ext-enable xdebug

CMD sudo apache2-foreground