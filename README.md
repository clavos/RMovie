# RMovie


Pour compiler le js et css en dev : 
 yarn encore dev --watch

Pour compiler & minifier les fichiers (En prod) : 
 yarn encore production

Nous souhaitons réaliser un site proposant à la suite d’une création de compte la possibilité d’accéder 
à une vaste base de données des films sortis jusqu’à aujourd’hui et de les trier dans des listes personnelles “vu”, “à voir”, 
il est de plus possible d’accéder à la page d’un film pour découvrir sa description et obtenir la possibilité de le noter ou de
laisser un commentaire. La compte personnel de l’utilisateur donnera accès à ses listes mais aussi à des statistiques sur ses visionnages.
Enfin il sera possible d’avoir une liste d’amis et de partager certaines informations avec ceux-ci.

# Installation

Clonez le projet
```bash
#  git clone https://github.com/clavos/RMovie.git
```

Installez les librairies utilisées
```bash
#  git composer install
```

Créez la base de données 'rmovie' sur votre phpmyadmin et modifiez le fichier .env pour y mettre les bons logs et le port de la base de données.

Enclenchez les migrations
```bash
#  php bin/console make:migration
#  php bin/console doctrine:migrations:migrate
```
