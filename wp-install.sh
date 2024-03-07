#!/bin/bash

until php -r "new mysqli('db:3306', '$MYSQL_USER', '$MYSQL_PASSWORD', '$MYSQL_DATABASE');" &> /dev/null; do
    echo 'En attente de la base de données MySQL...'
    sleep 1
done

echo 'La base de données MySQL est prête.'

# Définir les variables nécessaires pour WP-CLI
export WP_HOME="${WORDPRESS_SITE_URL}"
export WP_SITEURL="${WORDPRESS_SITE_URL}"
export HTTP_HOST=$(echo $WP_HOME | awk -F/ '{print $3}')

echo 'Variables sont prête.'
echo "${WORDPRESS_SITE_URL}"
echo "${WORDPRESS_ADMIN_USER}"
echo "${WORDPRESS_ADMIN_PASSWORD}"
echo "${WORDPRESS_ADMIN_EMAIL}"

if ! wp core is-installed --allow-root --debug; then
    wp core install --url="$WORDPRESS_SITE_URL" --title="$WORDPRESS_SITE_TITLE" --admin_user="$WORDPRESS_ADMIN_USER" --admin_password="$WORDPRESS_ADMIN_PASSWORD" --admin_email="$WORDPRESS_ADMIN_EMAIL" --path="/var/www/html" --allow-root --debug
else
    echo "WordPress est déjà installé."
fi

exec php-fpm