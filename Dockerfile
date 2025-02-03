# Use PHP 8.2 FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory inside the container
WORKDIR /var/www

# Copy Symfony project files into the container
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies (run Composer)
RUN composer install

# Expose the necessary port (Vercel listens on port 8080)
EXPOSE 8080

# Start PHP-FPM to handle requests
CMD ["php-fpm"]