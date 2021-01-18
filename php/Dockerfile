FROM php:7.3.26-apache

RUN apt-get update
RUN apt-get install -qy --no-install-recommends git
RUN apt-get install -qy --no-install-recommends zlib1g-dev
RUN apt-get install -qy --no-install-recommends libzip-dev
RUN apt-get install -qy --no-install-recommends apache2-utils
RUN a2enmod rewrite
RUN apt-get clean

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

#RUN apachectl restart
