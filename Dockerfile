FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /app
COPY . /app
RUN composer install --no-scripts
EXPOSE 8282
CMD php artisan serve --host=0.0.0.0 --port=8282
