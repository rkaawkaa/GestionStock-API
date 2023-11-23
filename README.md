# Projet LP Dev Mob FullStack 2023

## KIOSQUE IUT: Gestionnaire de matériels informatiques pour l'IUT de la Rochelle

Ce projet est une application web avec un back-end en Symfony/API Platform de gestion de stock de matériel informatique développé dans le cadre de la Licence professionnelle Développement Mobile parcours Full Stack de l'IUT de La Rochelle. Il a été réalisé par KAWKA Robin, HURDEBOURCQ Romain, HELIAS Arthur et PIHAN Alexis.


## Dépots
L'application est composée de deux dépots :

- Le dépot front contenant l'application React JS
- Le dépot back contenant les composants API Platform

## Installation du projet : 

## 1. Lancer la Stack Docker

Il faut avoir docker installé sur sa machine.<br>
`docker compose up --build -d` Build de la stack

## 2. Lancer le serveur symfony

`docker exec -it dwcs-php bash` pour lancer un bash dans le container du symfony

`composer install` pour télécharger les dépendances symfony

`symfony server:start` pour démarrer le serveur symfony

## 3. Accéder à la base de données

`docker exec -it dwcs-db bash` Lancement du container de la BDD

`mariadb -u root -p` Se connecter à la BDD

`USE dwcs;` Utiliser la BDD et pouvoir accéder aux tables

## Utilisation

L'application permet aux utilisateurs (le secrétariat notamment.) de consulter la liste des matériels disponibles, empruntés et en attente. Ils peuvent également gérer l'emprunt d'un matériel et son retour.

## Fonctionnalités : 

- Consultation de la liste des matériels disponibles, empruntés et en attente
- Emprunt de matériel disponible à un utilisateur
- Gestion du retour de l'emprunt

## Technologies utilisées : 

- PHP comme langage
- Symfony comme framework de développement PHP
-  API Platform comme framework de développement d'API RESTful, construit sur Symfony
- Doctrine comme ORM
