FROM php:7.2-fpm

RUN apt update && apt install zip git zlib1g-dev libzip-dev unzip libpq-dev -y

RUN docker-php-ext-install pdo pdo_mysql zip

# For Development Use
# RUN mkdir /srv/composer
# WORKDIR /srv/composer
# RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
