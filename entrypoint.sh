#!/bin/bash

# Fix permissions
echo "Setting proper permissions on wp-content and its subdirectories..."
chmod 775 /var/www/html/wp-content
chmod 775 /var/www/html/wp-content/plugins
chmod 775 /var/www/html/wp-content/themes
chmod 775 /var/www/html/wp-content/uploads

usermod -a -G users www-data
usermod -a -G root www-data

chown -R www-data:www-data /var/www/html

# Run any setup script
echo "Running wp-install.php script..."
php /usr/local/bin/wp-install.php

# Call default docker-php-entrypoint with the command passed to the entrypoint
echo "Starting PHP-FPM..."
exec docker-php-entrypoint php-fpm
