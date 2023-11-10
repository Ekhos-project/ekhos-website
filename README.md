# Ekhos

Landing page du site Ekhos.

## Démarrage rapide

Ces instructions vous permettront d'obtenir une copie du projet opérationnelle sur votre machine locale à des fins de développement et de test.

### Prérequis

- Docker  
- Docker Compose

### Installation

Clonez le dépôt sur votre machine locale :

```sh
git clone git@github.com:Ekhos-project/ekhos-website.git
cd ekhos-website
```

### Configuration

Avant de démarrer, vous devez créer un fichier `.env` à la racine de votre projet pour stocker les variables d'environnement nécessaires au `docker-compose.yml`.

Exemple de contenu pour `.env` :

```env
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpressuser
MYSQL_PASSWORD=wordpresspass
WORDPRESS_DB_HOST=db
WORDPRESS_DB_USER=${MYSQL_USER}
WORDPRESS_DB_PASSWORD=${MYSQL_PASSWORD}
WORDPRESS_DB_NAME=${MYSQL_DATABASE}
```

Remplacez `rootpassword`, `wordpress`, `wordpressuser`, `wordpresspass` avec les valeurs que vous souhaitez utiliser pour votre base de données.

### Lancer le projet

Pour lancer le projet, exécutez :

```sh
sudo docker-compose up -d
```

Votre site WordPress est maintenant accessible à `http://localhost:8000` et PHPMyAdmin à `http://localhost:8080`.

### Développement

Les fichiers de thèmes et de plugins peuvent être ajoutés dans le répertoire local qui est lié au volume `./:/var/www/html/wp-content`.