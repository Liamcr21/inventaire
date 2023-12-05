# Utilisez une image PHP officielle
FROM php:7.4-fpm

# Installez les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip

# Installez les extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql mbstring zip

# Définissez le répertoire de travail
WORKDIR /var/www/html

# Copiez les fichiers de l'application dans le conteneur
COPY . /var/www/html

# Définissez les autorisations appropriées
RUN chown -R www-data:www-data /var/www/html

# Exposez le port si nécessaire
# EXPOSE 9000

CMD ["php-fpm"]
