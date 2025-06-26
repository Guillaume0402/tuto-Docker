# 📋 Changelog

Toutes les modifications notables de ce projet seront documentées dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),
et ce projet adhère au [Versioning Sémantique](https://semver.org/lang/fr/).

## [Non publié]

### 🎁 Version 1.1.0 - Transformation vers la gratuité complète

#### Ajouté

-   **Formation 100% gratuite** : Suppression de toutes les références aux prix
-   **Badges "Gratuit"** sur toutes les pages principales (accueil, cours, about)
-   **Scripts de lancement** avec message de gratuité (`start-free-training.sh/.bat`)
-   **Documentation enrichie** avec mise en avant de la gratuité
-   **Licence MIT** et code open source

#### Modifié

-   **Base de données** : Tous les prix des cours mis à 0.00
-   **Interface utilisateur** : Remplacement des prix par badges "GRATUIT"
-   **Modèle Course** : Prix fixé à 0 par défaut pour nouveaux cours
-   **Messages d'inscription** : Adaptation pour formation gratuite
-   **README.md** : Mise en avant de la gratuité avec badges

#### Supprimé

-   Toutes les références aux prix dans les vues
-   Options de tri par prix
-   Garantie de remboursement (plus nécessaire)
-   Icônes de carte de crédit remplacées par cœurs

### Prévu pour la v2.0

-   API REST complète pour les modules
-   Application mobile React Native
-   Mode PWA hors-ligne
-   Intégration Kubernetes avancée

## [1.0.0] - 2025-01-15

### 🎉 Version initiale - Formation Docker Complète

#### Ajouté

-   **Architecture MVC** complète en PHP vanilla
-   **18 modules de formation** progressifs (débutant → avancé)
-   **Système d'authentification** sécurisé avec sessions
-   **Interface responsive** Bootstrap 5 avec SCSS
-   **Docker Compose** stack complète (PHP, MySQL, Mailhog, phpMyAdmin)
-   **Gestion des cours** avec filtres et tri dynamique
-   **Dashboard utilisateur** avec suivi de progression
-   **Formulaire de contact** avec intégration Mailhog
-   **Pages statiques** : accueil, à propos, contact
-   **Système de routage** personnalisé avec contrôleurs

#### Modules pédagogiques

-   **Débutant (1-4)** : Introduction, Installation, Images, Conteneurs
-   **Intermédiaire (5-10)** : Dockerfile, Compose, Réseaux, Stockage, Sécurité, Registry
-   **Avancé (11-18)** : Swarm, Kubernetes, CI/CD, Monitoring, Performance, Projets

#### Fonctionnalités techniques

-   **Docker Compose** avec services isolés
-   **Hot reload** pour le développement SCSS
-   **Volumes persistants** pour base de données
-   **Variables d'environnement** configurables
-   **Logs centralisés** et monitoring
-   **Sécurité** : CSRF, validation, hash des mots de passe
-   **Cache optimisé** pour les assets statiques

#### Documentation

-   **README.md** complet avec guide d'installation
-   **CONTRIBUTING.md** pour les contributeurs
-   **Structure de projet** documentée
-   **Commandes Make** pour le développement
-   **Variables d'environnement** documentées

### Infrastructure

-   **PHP 8.2** avec Apache 2.4
-   **MySQL 8.0** avec données d'exemple
-   **Mailhog** pour tests d'emails en local
-   **phpMyAdmin** pour administration base de données
-   **Bootstrap 5** avec compilation SCSS
-   **Font Awesome** pour les icônes

### Sécurité

-   Validation et échappement des données utilisateur
-   Protection CSRF sur tous les formulaires
-   Hash sécurisé des mots de passe (password_hash)
-   Sessions sécurisées avec expiration
-   Variables d'environnement pour les secrets

## [0.9.0] - 2024-12-20

### 🔧 Version Beta - Tests et finalisations

#### Ajouté

-   Structure de base MVC
-   Configuration Docker initiale
-   Authentification basique
-   Interface Bootstrap préliminaire

#### Modifié

-   Optimisation des Dockerfiles
-   Amélioration des performances
-   Correction des bugs de sécurité

#### Supprimé

-   Code legacy et fichiers inutiles
-   Dépendances obsolètes

## [0.5.0] - 2024-11-15

### 🏗️ Version Alpha - Développement initial

#### Ajouté

-   Preuve de concept Docker + PHP
-   Base de données MySQL
-   Premières vues et contrôleurs
-   Configuration d'environnement

#### En cours

-   Architecture MVC
-   Système d'authentification
-   Interface utilisateur

---

## Types de changements

-   🎉 `Ajouté` pour les nouvelles fonctionnalités
-   🔧 `Modifié` pour les changements de fonctionnalités existantes
-   🗑️ `Déprécié` pour les fonctionnalités bientôt supprimées
-   🚫 `Supprimé` pour les fonctionnalités supprimées
-   🐛 `Corrigé` pour les corrections de bugs
-   🔒 `Sécurité` en cas de vulnérabilités corrigées

## Liens

-   [Unreleased]: https://github.com/repo/tuto-docker/compare/v1.0.0...HEAD
-   [1.0.0]: https://github.com/repo/tuto-docker/compare/v0.9.0...v1.0.0
-   [0.9.0]: https://github.com/repo/tuto-docker/compare/v0.5.0...v0.9.0
-   [0.5.0]: https://github.com/repo/tuto-docker/releases/tag/v0.5.0
