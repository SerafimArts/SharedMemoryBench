FROM php:8.2-cli

WORKDIR "/home/memory-bench"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update

# ------------------------------------------------------------------------------
# Installation Dependencies
# ------------------------------------------------------------------------------

RUN apt-get update \
    && pecl channel-update pecl.php.net \
    && apt-get -y --no-install-recommends install \
      libicu-dev \
      libzip-dev \
      libffi-dev \
      unzip \
      git \
      curl

# Composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer

# APCU
RUN pecl install apcu
RUN docker-php-ext-enable apcu

# SysVShm
RUN docker-php-ext-install sysvshm
RUN docker-php-ext-enable sysvshm

# FFI
RUN docker-php-ext-install ffi
RUN docker-php-ext-enable ffi

# SHMOP
RUN docker-php-ext-install shmop
RUN docker-php-ext-enable shmop

# SYNC
RUN pecl install sync
RUN docker-php-ext-enable sync

# Zip
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip


# Opcache
RUN docker-php-ext-install opcache

# ------------------------------------------------------------------------------
# Cleanup Dependencies
# ------------------------------------------------------------------------------

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && ln -sf /usr/share/zoneinfo/Etc/UTC /etc/localtime
