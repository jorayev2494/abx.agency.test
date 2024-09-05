FROM php:8.2-cli as base

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
    && apt-get -y --no-install-recommends install imagemagick php8.2-imagick php8.2-pgsql pdo_pgsql php8.2-mysql pdo nano php8.2-gd php8.2-redis php8.2-bcmath php8.2-zmq \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#endregion

# Imagick is installed from the archive because regular installation fails
# See: https://github.com/Imagick/imagick/issues/643#issuecomment-1834361716
# https://gist.github.com/Wirone/d5c794b4fef0203146a27687e80588a6
#ARG IMAGICK_VERSION=3.7.0
#RUN curl -L -o /tmp/imagick.tar.gz https://github.com/Imagick/imagick/archive/refs/tags/${IMAGICK_VERSION}.tar.gz \
#    && tar --strip-components=1 -xf /tmp/imagick.tar.gz \
#    && phpize \
#    && ./configure \
#    && make \
#    && make install \
#    && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini \
#    && rm -rf /tmp/*
#    # <<< End of Imagick installation


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
