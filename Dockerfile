FROM php:8.2-apache

# Install system deps for extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       libsqlite3-dev \
       default-libmysqlclient-dev \
       zlib1g-dev \
       libzip-dev \
       unzip \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql mysqli zip \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy app
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
