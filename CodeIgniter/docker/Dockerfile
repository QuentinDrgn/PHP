# Use the official PHP image with FPM (FastCGI Process Manager)
FROM php:8.1-fpm

# Set the working directory inside the container
WORKDIR /app

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install other necessary packages if required
# For example: install the GD extension for image manipulation
# RUN docker-php-ext-install gd

# Copy the application files to the container
COPY ../app /app

# Copy the public directory where index.php is located
COPY ../public /public

# Copy the custom PHP configuration file
COPY ../docker/custom_php.ini /usr/local/etc/php/conf.d/custom.ini

# Expose port 9000 for PHP-FPM
EXPOSE 9000
