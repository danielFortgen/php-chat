FROM php:7.4-fpm-alpine

COPY ./src /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer 

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN composer install -d .

RUN composer require mollie/mollie-api-php:^2.0