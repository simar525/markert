# Use the official PHP image, specify the version you need
FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libssh2-1-dev \
    libmcrypt-dev \
    libmagickwand-dev --no-install-recommends

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip soap

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www

# Set file permissions
RUN chown -R www-data:www-data /var/www

# Expose port 9000
EXPOSE 9000

# Start the php-fpm server
CMD ["php-fpm"]