FROM php:8.1-apache

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activation du module Apache rewrite
RUN a2enmod rewrite

# Configuration Apache pour le projet
COPY docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuration PHP
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/error-reporting.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/error-reporting.ini
RUN echo "log_errors = On" >> /usr/local/etc/php/conf.d/error-reporting.ini
RUN echo "error_log = /var/www/html/logs/error.log" >> /usr/local/etc/php/conf.d/error-reporting.ini

# Définir le répertoire de travail
WORKDIR /var/www/html

RUN echo "ServerTokens Prod\nServerSignature Off" > /etc/apache2/conf-available/security.conf \
    && a2enconf security


# Exposer le port 80
EXPOSE 80
