FROM php:7.1-fpm-stretch

ENV ACCEPT_EULA=Y

RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests nginx ssh zlib1g-dev \
    && apt-get clean --dry-run

RUN docker-php-ext-install opcache zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

############################
#         COMPOSER         #
############################

RUN curl --silent --show-error https://getcomposer.org/installer | php \
    && mv ./composer.phar /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer

############################
#           NPM            #
############################

RUN curl https://deb.nodesource.com/setup_10.x | bash \
    && apt install -y nodejs \
    && npm install -g gulp yarn

############################
#          MYSQL           #
############################

RUN docker-php-ext-install pdo pdo_mysql

############################
#         MONGODB          #
############################
RUN apt-get install -y libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www
