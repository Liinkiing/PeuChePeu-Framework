# Qu'est ce que c'est que ça ?

Dans le but de préparer des tutoriels sans frameworks, j'essaie de construire une base qui pourra être utilisée pour 
de futures vidéos. Le but est de construire une base propre et organisée : 

## Principe

- **Core**, fournit les fonctionnalitées abstraites qui seront partagées entre les projets
- **App/Base**, fournit les élément partagés par les bloc de l'application
- **App/{Blog,Payment,Auth...}**, permet de créer des bloc interchangeable et réutilisable dans l'application. Le 
principe est de découper notre application en fonction du contexte, plutôt que d'appliquer une structure MVC à la 
lettre. Chaque bloc doit avoir une classe `Loader` qui permet d'enregistrer les routes, les classes ou autre. Ce 
Loader.

## Dépendances

- **Slim**, pour gérer le routeur
- **PHP-DI**, pour gérer l'injection de dépendance
- **Twig**, pour les templates