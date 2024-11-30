# Use the official PHP Apache image as a base image
FROM php:8.3-apache

# Install required extensions
RUN docker-php-ext-install pdo_mysql

# Enable mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Set the server name to avoid warning messages
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set the working directory (make sure this matches your app's directory inside the container)
WORKDIR /var/www/html

# Expose port 80 for the web server (this is already covered by docker-compose)
EXPOSE 80
