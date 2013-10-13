GAS - Gestion d'Association Simple
==================================


= Objectif =

L'objectif de GAS est de gérer une petite association. Gérer une association
comprend à la base gérer la liste des membres d'une année en cours.

Par extension, on pourra gérer :
	* les relances d'adhésions
	* les inscriptions/désinscriptions à une liste de diffusion,
	* la comptabilité,
	* etc

L'architecture devra être modulaire pour permettre ces extensions.

Le choix de Symfony 2 est basé sur sa modularité et sa maturité. 

= TODO =

== Version 1.0 (Methane) ==

* Permettre la saisie de base des adhérents (nom, prénom, date de
naissance, email, date de l'adhésion/réadhésion)
* Réaliser des recherches sur cette liste d'adhérents
* Editer la liste des adhérents d'une année
* Importer et exporter la liste des adhérents au format CSV

== Version 1.1 (Ethane) ==

* Les relances avec envoi d'une fiche d'adhésion, éventuellement
pré-remplie

== Version 1.2 (Propane) ==

* Gestion des inscriptions/désincriptions à une liste de diffusion,
en se basant sur Sympa en premier

== Version 1.3 (Buthane) ==

* Préparer les remises de chèques
* Exporter les adhésions dans un/des formats comptables

= Architecture =

== Sources ==

Les sources seront stockés dans un dépôt Git hébergé sur le serveur
de Linux-Nantes, et répliqués sur Github.

== Language ==

GAS sera écrit en PHP, avec le framework Symfony 2.

== Base de données ==

La base cible est MySQL, mais on pourra utiliser PostgreSQL, H2, etc.

== Méthode de développement ==

GAS devra suivre la méthode de développement TDD (Test Driven Developpement).

== Gestion du projet et documentation ==

La gestion du projet se fera avec Trac, de même que la documentation
utilisateur et technique.

La documentation embarquée sera uniquement les instructions technique
d'installation, de mise à jour et de configuration. Elle sera écrite en
syntaxe MarkDown.

== Licence ==

La licence sera la GPL v3+.

