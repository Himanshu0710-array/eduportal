FROM php:8.2-apache

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy project files to the web root
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
