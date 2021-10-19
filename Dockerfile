FROM php:7.3-fpm

# Set working directory
WORKDIR /app

#Copy files into the working directory
COPY . /app

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install pdo pdo_mysql mysqli gd
RUN docker-php-ext-enable mysqli

#Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Install laravel packages
RUN composer install

#Run on port 8000
EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000