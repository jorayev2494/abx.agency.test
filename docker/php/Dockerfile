FROM php:8.3-fpm as base

# create user
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

WORKDIR /var/project

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y libmagickwand-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y nano \
    && apt-get install -y php-mysql \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf g++ libtool make pcre-dev \
    && apt-get install -y libmagickwand-dev \
    #####################
    && apt-get -y install mbstring imagemagick php8.3-imagick php8.3-pcntl php8.3-gd php8.3-mysql php8.3-sqlite nano php8.3-redis php-bcmath php8.3-zmq pdo_mysql pdo \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


# Imagick is installed from the archive because regular installation fails
# See: https://github.com/Imagick/imagick/issues/643#issuecomment-1834361716
# https://gist.github.com/Wirone/d5c794b4fef0203146a27687e80588a6
ARG IMAGICK_VERSION=3.7.0
RUN curl -L -o /tmp/imagick.tar.gz https://github.com/Imagick/imagick/archive/refs/tags/${IMAGICK_VERSION}.tar.gz \
    && tar --strip-components=1 -xf /tmp/imagick.tar.gz \
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
#endregion

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./php.ini $PHP_INI_DIR/php.ini


FROM base as develop

# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug


FROM base as production

