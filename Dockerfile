FROM php:8.3-cli

# Installer les dépendances système et extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier le projet dans le conteneur
COPY . .

# Installer les dépendances PHP (sans les outils de développement)
RUN composer install --no-dev --optimize-autoloader

# Précompiler la configuration
RUN php artisan config:cache

EXPOSE 8000

# Démarrer : appliquer les migrations puis lancer le serveur
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT