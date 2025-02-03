# Use PHP 8.2 FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Install necessary system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Set the working directory inside the container
WORKDIR /var/www

# Copy Symfony project files into the container
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set correct file permissions
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www

# Increase PHP memory limit to avoid memory errors
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Clear Composer cache before installing dependencies
RUN composer clear-cache

# Install dependencies safely
RUN composer install --no-interaction --no-progress --optimize-autoloader

# Expose the necessary port (Vercel listens on port 8080)
EXPOSE 8080

# Start PHP-FPM to handle requests
CMD ["php-fpm"]