#FROM composer:2.0.7 as build
FROM oberd/php-8.1-apache

WORKDIR /app
COPY . /app

#RUN rm composer.lock
RUN php composer.phar install --ignore-platform-reqs

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd soap zip sockets

RUN pecl install redis && docker-php-ext-enable redis

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 80
#COPY --from=build /app /app
RUN rm -f /etc/apache2/sites-enabled/default.conf
COPY vhost.conf /etc/apache2/sites-enabled/default.conf
RUN chown -R www-data:www-data /app \
    && a2enmod rewrite
