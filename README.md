# Qu'est ce que c'est que ça ?

[![Build Status](https://travis-ci.org/Grafikart/PeuChePeu-Framework.svg?branch=master)](https://travis-ci.org/Grafikart/PeuChePeu-Framework)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/18505987-b86b-4b3e-bf8a-07bff9c5ef96/mini.png)](https://insight.sensiolabs.com/projects/18505987-b86b-4b3e-bf8a-07bff9c5ef96)
[![Coverage Status](https://coveralls.io/repos/github/Grafikart/PeuChePeu-Framework/badge.svg?branch=master)](https://coveralls.io/github/Grafikart/PeuChePeu-Framework?branch=master)

Dans le but de préparer des tutoriels "sans frameworks", j'essaie de construire une base qui pourra être utilisée pour 
de futures vidéos. Le but est de construire une base propre et organisée qui peut facilement être étendue avec des 
modules qui fonctionnent de manière indépendantes. 

## Principe

- **Core**, fournit les fonctionnalitées abstraites qui seront partagées entre les projets
- **App/Base**, fournit les élément partagés par les bloc de l'application
- **App/{Blog,Payment,Auth...}**, permet de créer des bloc interchangeable et réutilisable dans l'application. Le 
principe est de découper notre application en fonction du contexte, plutôt que d'appliquer une structure MVC à la 
lettre. Chaque bloc doit avoir une classe `Loader` qui permet d'enregistrer les routes, les classes ou autre. Ce 
Loader.

## Dépendances

- [Slim](https://www.slimframework.com/), pour gérer le routeur
- [PHP-DI](http://php-di.org/), pour gérer l'injection de dépendance, à voir pour la suite si ça ne "complique" pas 
trop la compréhension
- [Twig](https://twig.sensiolabs.org/), pour les templates
- [Phinx](https://phinx.org/), pour gérer les migrations et le seeding de la base de données
- [PHPUnit](https://phpunit.de/), pour les tests unitaires (what else ?)
- [php-ref](https://github.com/digitalnature/php-ref), pour des debugs plus joli :)
- [Pagerfanta](https://github.com/whiteoctober/Pagerfanta), pour paginer les résultats

## Réflexions

- L'utilisation d'un **ORM** n'est pas encore prévue, je pense que même si ça clarifie le code cela apporte aussi une 
couche d'abstraction qui ne convient pas à tous les projets et c'est très long / chiant à tester. Choisir un ORM 
tiers va rendre notre application dépendante de cette ORM donc on essaiera tant que possible de rester sur PDO.
- Pour créer des commandes perso on n'utilisera pas le composant **Symfony/Console** mais on se "contentera" d'un 
fichier MakeFile. Inutile de réinventer la roue et nos besoins restens relativement simple (des alias).
- Créer les tests unitaires en parallèle du projet est intéréssant mais je ne suis pas sûr de le faire en vidéo car 
c'est long et répétitif (au pire ils seront fournis avec les sources)

## Todo

- [x] Poser la base Slim / PHP-DI
- [ ] Module Blog (front, permet de voir l'interaction avec la base de données)
- [x] Système de migration / seed
- [x] Tests unitaires
- [ ] Page contact (permet de voir le traitement des formulaire)
- [ ] Authentification des utilisateur
- [ ] Back-end de la partie blog

### Bloc e-commerce

- [ ] Gestion du catalogue produit
- [ ] Mise en place de l'achat direct d'un produit (paiement via stripe surement)

### Bloc e-commerce (monnaire virtuelle)

- [ ] Achat de points (monnaie intermédiaire)
- [ ] Achat d'un produit en utilisant les points obtenus

## Participer ?

Pour le moment je pose la base donc ne faites pas de PR avec du nouveau code par contre si vous le souhaitez vous 
pouvez critiquer le code existant et proposer des changements / refactor. Le but n'est pas de créer le prochain 
Laravel / Symfony, mais de voir comment on peut créer une structure de projet avec PHP7.