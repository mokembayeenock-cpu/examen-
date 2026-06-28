# Dockerfile pour PHP avec Apache
FROM php:8.1-apache

# Installer extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier les fichiers du projet
COPY . /var/www/html/

# Configurer Apache
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/docker.conf

RUN a2enconf docker

# Permissions
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Créer dossiers uploads
RUN mkdir -p /var/www/html/assets/uploads/photos
RUN chmod 777 /var/www/html/assets/uploads/photos

EXPOSE 80

# Script de démarrage
COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
