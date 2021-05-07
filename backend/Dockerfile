FROM php:7.3-apache

# Install packages
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

# Apache configuration
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

# Common PHP Extensions
RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql

RUN apt-get install -y sqlite3 libsqlite3-dev

RUN docker-php-ext-install pdo_sqlite

# Ensure PHP logs are captured by the container
ENV LOG_CHANNEL=stderr

# Set a volume mount point for your code
# VOLUME /var/www/tmp

# Copy code and run composer
COPY . /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN cd /var/www/html && composer install --optimize-autoloader --no-dev

COPY app /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN php artisan config:clear
# RUN ln -s /var/www/tmp/public /var/www/html/
EXPOSE 8000
# The default apache run command
CMD ["apache2-foreground"]

# az webapp config appsettings set --resource-group lab --name openlabbe --settings WEBSITES_PORT=8000
