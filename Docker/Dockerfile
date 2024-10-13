# Use the official PHP image with FPM (FastCGI Process Manager)
FROM php:8.1-fpm

# Set the working directory inside the container
WORKDIR /app

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install other necessary packages if required
# For example: install the GD extension for image manipulation
# RUN docker-php-ext-install gd

# Copy the application files to the container
COPY ../app /app

# Copy the public directory where index.php is located
COPY ../public /public

# Expose port 9000 for PHP-FPM
EXPOSE 9000
