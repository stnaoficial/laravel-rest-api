# Use a base image for ARM architecture
FROM arm64v8/php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN { echo '#!/bin/sh'; echo 'exec pkg-config "$@" freetype2'; } > /usr/local/bin/freetype-config && chmod +x /usr/local/bin/freetype-config

RUN apt update && apt install -y libonig-dev libzip-dev

# Install extensions
RUN docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl bcmath
RUN docker-php-ext-configure gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install docker sockets
RUN docker-php-ext-install sockets

RUN apt-get update -y && apt-get upgrade -y && apt-get install git libssl-dev -y

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Set the working directory
WORKDIR /var/www

# Copy your PHP application files to the container
COPY . .

# Expose the port used by PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]