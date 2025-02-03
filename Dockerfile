# Use PHP 8.2 CLI
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Set working directory
WORKDIR /var/www

# Copy Symfony project files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www

# Install dependencies
RUN composer install --no-interaction --no-progress --optimize-autoloader

# Expose Vercel's default port (8080)
EXPOSE 8080

# Run PHP's built-in web server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]