# 📋 Guide Complet du Projet

## 🎯 À Propos

Ce projet est une plateforme d'apprentissage Docker complète avec une architecture MVC en PHP. Consultez le [README.md](../README.md) principal pour la documentation détaillée de la formation.

## 🏗️ Architecture

### Structure des Dossiers

```
tuto-Docker/
├── app/                 # Application MVC
│   ├── Controllers/     # Contrôleurs
│   ├── Models/         # Modèles
│   ├── Views/          # Vues
│   └── Core/           # Classes principales
├── config/             # Configuration
├── content/            # Modules de formation
├── docker/             # Configuration Docker
├── docs/               # Documentation (ce dossier)
├── public/             # Point d'entrée web
├── scripts/            # Scripts utilitaires
└── training/           # Scripts de formation
```

## 🐳 Docker

### Commandes Principales

```bash
# Démarrer l'environnement
docker-compose up -d

# Arrêter l'environnement
docker-compose down

# Voir les logs
docker-compose logs -f
```

### Services

-   **web** : Serveur Apache/PHP
-   **db** : Base de données MySQL
-   **phpmyadmin** : Interface d'administration DB

## 🎓 Formation

### Démarrage Rapide

```bash
# Windows
./training/start-free-training.bat

# Linux/Mac
./training/start-free-training.sh
```

### Modules Disponibles

Consultez le dossier `content/modules/` pour tous les modules de formation disponibles.

## 🧪 Tests

### Scripts de Test

```bash
# Tests des routes
./scripts/test-routes.sh

# Tests des statistiques
./scripts/test-statistics.sh
```

## 🤝 Contribution

Ce projet est 100% gratuit et open source. Les contributions sont les bienvenues !

### Comment Contribuer

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push sur la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Changelog

### Version Actuelle

-   ✅ Architecture MVC complète
-   ✅ 18 modules de formation
-   ✅ Configuration Docker optimisée
-   ✅ Interface web responsive
-   ✅ Système de gestion des cours

### Prochaines Fonctionnalités

-   🔄 Système de quiz interactifs
-   🔄 Dashboard statistiques avancé
-   🔄 Module de certification
-   🔄 API REST complète

## 📞 Support

-   📧 Issues GitHub pour les bugs
-   💬 Discussions GitHub pour les questions
-   📖 Documentation dans `content/modules/`

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](../LICENSE) pour plus de détails.
