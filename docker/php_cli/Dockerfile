FROM php:8.3-cli as base

ENV PHP_MODE php-cli

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

WORKDIR /var/project

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y libjpeg-dev \
    && apt-get install -y libmagickwand-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y nano \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf g++ libtool make pcre-dev \
    && apt-get install -y libmagickwand-dev \
    && postgresql-dev \
    # Image extensions
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd \
    # Install
    && apt-get -y --no-install-recommends install imagemagick php8.3-imagick php8.3-pgsql pdo_pgsql php8.3-mysql pdo nano php8.3-gd php8.3-redis php8.3-bcmath php8.3-zmq \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
#endregion

# Imagick is installed from the archive because regular installation fails
# See: https://github.com/Imagick/imagick/issues/643#issuecomment-1834361716
# https://gist.github.com/Wirone/d5c794b4fef0203146a27687e80588a6
# ARG IMAGICK_VERSION=3.7.0
# RUN curl -L -o /tmp/imagick.tar.gz https://github.com/Imagick/imagick/archive/refs/tags/${IMAGICK_VERSION}.tar.gz \
#     && tar --strip-components=1 -xf /tmp/imagick.tar.gz \
#     && phpize \
#     && ./configure \
#     && make \
#     && make install \
#     && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini \
#     && rm -rf /tmp/*
#     # <<< End of Imagick installation

# ARG IMAGICK_VERSION=3.7.0
# RUN curl -L -o /tmp/imagick.tar.gz https://github.com/Imagick/imagick/archive/refs/tags/${IMAGICK_VERSION}.tar.gz \

COPY ./extensions/imagick.tar.gz /tmp/imagick.tar.gz

RUN tar --strip-components=1 -xf /tmp/imagick.tar.gz \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini \
    && rm -rf /tmp/*
    # <<< End of Imagick installation

# Install MySQLi
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install PDO
RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

############################################################################################
FROM base as local

############################################################################################
FROM base as develop

############################################################################################
FROM base as production
