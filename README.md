# Projet Symfony

DoItTogether est une application qui connecte les personnes souhaitant partager des activités avec d’autres, plutôt que de les faire seules. Les utilisateurs peuvent publier ou découvrir des annonces proposant diverses expériences et réserver du temps avec quelqu'un pour profiter ensemble d’un moment convivial, enrichissant ou divertissant.

## Prérequis

-   PHP >= 8.2
-   Composer
-   Node.js et npm
-   Symfony CLI
-   Docker pour la réception d'emails avec Mailhog.

# Lancer le projet

-   lancer `composer install`
-   créer la base de données MySQL `db_projet_symfony` ou utiliser votre propre base de données
-   lancer `php bin/console doctrine:migrations:migrate`
-   lancer `php bin/console hautelook:fixtures:load`
-   lancer `symfony serve`
-   lancer `docker compose up -d ` (for mailhog)

# Roles test

-   Utilisateurs générés avec les Fixtures
    -   adrien.quacchia@gmail.com adrien1234 for ROLE_ADMIN
    -   john.smith@gmail.com john1234 for ROLE_USER

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
