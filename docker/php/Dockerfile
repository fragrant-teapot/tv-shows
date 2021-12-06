FROM php:7.4

RUN apt-get update && apt-get install -y \
    apt-transport-https \
    lsb-release \
    ca-certificates \
    wget

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    curl \
    make \
    nano \
    libpq-dev \
    libgd-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    g++ \
    libicu-dev \
    zlib1g-dev \
    libxml2-dev \
    libssl-dev \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev

RUN docker-php-ext-install xml
RUN docker-php-ext-install phar
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache
RUN docker-php-ext-install curl
RUN docker-php-ext-install pdo pdo_mysql

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer --version
