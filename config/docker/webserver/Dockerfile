FROM php:8.1-apache

RUN apt update -y && \
    apt upgrade -y && \
    curl -fsSL https://deb.nodesource.com/setup_19.x | bash - && \
    apt install curl nano git zip nodejs wget -y

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd pdo_mysql xdebug apcu intl zip bcmath curl opcache xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf