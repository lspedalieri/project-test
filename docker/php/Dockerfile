FROM php:8.2-fpm AS base

# ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

# RUN mkdir -p /var/www/html

# ADD ./src/ /var/www/html

# RUN docker-php-ext-install pdo pdo_mysql

# RUN chown -R laravel:laravel /var/www/html

# Set working directory
WORKDIR /var/www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd bcmath

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libgd-dev \
    ffmpeg

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath
RUN docker-php-ext-configure gd --with-external-gd
RUN docker-php-ext-install gd

# RUN apt-get update && apt-get install -y \
#     software-properties-common \
#     npm
# RUN npm install npm@latest -g && \
#     npm install n -g && \
#     n latest


ENV NODE_VERSION=20.18.1
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version



# Install PECL extensions
RUN pecl install redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH="$PATH:/usr/local/bin"
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add unprivileged user
ARG user=www
ARG uid=1000

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www/html

# Change current user to $user
USER $user

FROM base AS dev

USER root

#RUN pecl install xdebug && docker-php-ext-enable xdebug

#COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#COPY ./docker/php/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

USER $user