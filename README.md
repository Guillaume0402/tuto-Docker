# Tutoriel Docker - Projet PHP MVC

Ce projet est un tutoriel pour apprendre Docker avec une application PHP en architecture MVC.

## Technologies utilisées

-   **PHP 8.1** avec Apache
-   **MySQL 8.0**
-   **Bootstrap 5** (SCSS)
-   **Docker & Docker Compose**
-   **Architecture MVC vanilla PHP**

## Installation

1. Clonez le projet

```bash
git clone <url-du-repo>
cd tuto-docker
```

2. Copiez le fichier d'environnement

```bash
cp .env.example .env
```

3. Lancez les conteneurs Docker

```bash
docker-compose up -d
```

4. Accédez à l'application

-   Site web : http://localhost:8080
-   PhpMyAdmin : http://localhost:8081

## Structure du projet

```
tuto-docker/
├── docker-compose.yml      # Configuration Docker
├── .env                    # Variables d'environnement
├── docker/                 # Images Docker personnalisées
├── db/                     # Scripts base de données
├── public/                 # Racine web publique
├── app/                    # Application MVC
├── config/                 # Configuration
├── mail/                   # Gestion des emails
└── logs/                   # Logs de l'application
```

## Fonctionnalités

-   [x] Authentification utilisateur
-   [x] Gestion des cours
-   [x] Formulaire de contact
-   [x] Dashboard utilisateur
-   [x] Interface responsive avec Bootstrap

## Commandes Docker utiles

```bash
# Démarrer les services
docker-compose up -d

# Arrêter les services
docker-compose down

# Voir les logs
docker-compose logs -f

# Reconstruire les images
docker-compose build --no-cache
```
