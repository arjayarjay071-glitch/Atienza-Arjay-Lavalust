ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-apache
# Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql
# Enable Apache mod_rewrite
RUN a2enmod rewrite
# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
# Ipasa ang Authorization header (para sa JWT) sa PHP
RUN echo 'SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1' > /etc/apache2/conf-available/authorization.conf \
    && a2enconf authorization
# Copy app files
COPY . /var/www/html/
# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
EXPOSE 80