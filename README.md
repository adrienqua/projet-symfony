# Projet Symfony

DoItTogether est une application qui connecte les personnes souhaitant partager des activités avec d’autres, plutôt que de les faire seules. Les utilisateurs peuvent publier ou découvrir des annonces proposant diverses expériences et réserver du temps avec quelqu'un pour profiter ensemble d’un moment convivial, enrichissant ou divertissant.

# Hébergement

Le projet est hébergé sur [https://symfony-project-c6ab13ae4acd.herokuapp.com/](https://symfony-project-c6ab13ae4acd.herokuapp.com/).

## Prérequis

-   PHP >= 8.2
-   Composer
-   Node.js et npm
-   Symfony CLI
-   Docker pour la réception d'emails avec Mailhog en environnement de développement.

# Lancer le projet

-   lancer `composer install` puis `composer update`
-   créer la base de données MySQL `db_projet_symfony` ou utiliser votre propre base de données
-   lancer `php bin/console doctrine:migrations:migrate`
-   lancer `php bin/console hautelook:fixtures:load`
-   lancer `symfony serve`
-   lancer `docker compose up -d ` (pour Mailhog)

# Roles test

-   Utilisateurs générés avec les Fixtures
    -   admin@gmail.com admin1234 for ROLE_ADMIN
    -   pekin.moyen@gmail.com pekin1234 for ROLE_USER

## Commandes personnalisées

-   php bin/console doittogether:make:category
-   Permet de créer une Category et l'enregistrer en BDD <br><br>

-   php bin/console doittogether:delete:category
-   Permet de supprimer une Category de la BDD <br><br>

-   php bin/console doittogether:edit:category
-   Permet de modifier une Category de la BDD <br><br>

-   php bin/console doittogether:export:categories
-   Permet d'exporter à la racine du projet, les données de la table Category au format CSV <br><br>

-   php bin/console doittogether:stats:category
-   Permet d'afficher des statistiques sur la table Category <br><br>
