<?php

$dbHost = 'db'; // Assurez-vous que cette variable est définie.
$dbUser = getenv('MYSQL_USER');
$dbPassword = getenv('MYSQL_PASSWORD');
$dbName = getenv('MYSQL_DATABASE');
$dbPort = 3306; // Utilisez le port par défaut de MySQL si non spécifié.

// Attendre que la base de données soit prête
while(true) {
    $conn = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName, $dbPort);
    if ($conn->connect_error) {
        echo "En attente de la base de données MySQL...\n";
        sleep(1);
    } else {
        echo "Connexion à la base de données réussie.\n";
        $conn->close();
        break;
    }
}

// Chemin vers le répertoire de WordPress
$wpPath = '/var/www/html';

// Commande WP-CLI pour vérifier si WordPress est installé
$checkCmd = "wp core is-installed --path=$wpPath --allow-root --debug";

// Exécuter la commande et récupérer le statut de sortie
exec($checkCmd, $output, $returnVar);

// Vérifier le statut de sortie
if ($returnVar !== 0) {
    // WordPress n'est pas installé, procéder à l'installation
    $WORDPRESS_SITE_URL = escapeshellarg(getenv('WORDPRESS_SITE_URL'));
    $WORDPRESS_SITE_TITLE = escapeshellarg(getenv('WORDPRESS_SITE_TITLE'));
    $WORDPRESS_ADMIN_USER = escapeshellarg(getenv('WORDPRESS_ADMIN_USER'));
    $WORDPRESS_ADMIN_PASSWORD = escapeshellarg(getenv('WORDPRESS_ADMIN_PASSWORD'));
    $WORDPRESS_ADMIN_EMAIL = escapeshellarg(getenv('WORDPRESS_ADMIN_EMAIL'));

    // Construire la commande d'installation WP-CLI
    $installCmd = "wp core install --url=$WORDPRESS_SITE_URL --title=$WORDPRESS_SITE_TITLE --admin_user=$WORDPRESS_ADMIN_USER --admin_password=$WORDPRESS_ADMIN_PASSWORD --admin_email=$WORDPRESS_ADMIN_EMAIL --path=$wpPath --allow-root --debug";

    // Exécuter la commande d'installation
    echo shell_exec($installCmd);
} else {
    // WordPress est déjà installé
    echo "WordPress est déjà installé.";
}

?>
