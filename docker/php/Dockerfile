FROM php:8.1-fpm

WORKDIR /var/www/html

########## Update and upgrade image repositories ##########
RUN apt-get update --fix-missing -y \
        && apt-get upgrade -y \
        && apt-get install -y nano htop procps

########## Installing dependencies ##########
RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl

########## SSL ##########
RUN apt-get install -y --no-install-recommends openssl

######### Mysql client ######
RUN apt-get install -y default-mysql-client

RUN apt-get install -y nginx curl git unzip && \
    docker-php-ext-install pdo_mysql && \
    pecl install redis && \
    docker-php-ext-enable redis


########## PHP zip ##########
RUN apt-get install -y --no-install-recommends libzip-dev unzip \
        && docker-php-ext-install zip

########## PHP exif ##########
RUN docker-php-ext-install exif


########## PHP bcmath ##########
RUN docker-php-ext-install bcmath


########## PHP pdo ##########
RUN docker-php-ext-install pdo pdo_mysql

########## PHP soap #########
RUN apt-get install -y \
     libxml2-dev \
     && docker-php-ext-install soap

########## Composer ##########
RUN mkdir /var/www/.composer \
        && chown www-data:www-data /var/www/.composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

######## ini ######
COPY php.ini-production ${PHP_INI_DIR}/php.ini
COPY opcache.ini ${PHP_INI_DIR}/conf.d/opcache.ini


########## PHP pcntl #########
RUN docker-php-ext-install pcntl

