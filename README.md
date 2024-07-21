# API Bibli

API Bibli est une application Symfony permettant de gérer une collection de livres. Ce projet inclut des tests PHPUnit pour s'assurer du bon fonctionnement des différentes fonctionnalités.

## Prérequis

- PHP 7.4 ou supérieur
- Composer
- MySQL
- Symfony CLI (optionnel mais recommandé)

## Installation

### Cloner le dépôt

- git clone https://github.com/votre-utilisateur/api-bibli.git
- cd api-bibli

## Installer les dépendances

- composer install

## Configuration de l'environnement

Dupliquer le fichier .env pour créer un fichier .env.local et modifier les variables nécessaires, notamment la connexion à la base de données.

- DATABASE_URL="mysql://root:@127.0.0.1:3306/api_bibli"


## Configuration de la base de données

Créer la base de données et exécuter les migrations :
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate


## Lancer le serveur de développement

- symfony server:start
