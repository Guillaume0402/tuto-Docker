# Application Node.js optimisée

Exemple d'une application Node.js avec Dockerfile optimisé suivant les meilleures pratiques.

## 🎯 Optimisations appliquées

1. **Image de base Alpine** : Réduction de ~900MB à ~50MB
2. **Cache des dépendances** : Copie des package.json avant le code
3. **Utilisateur non-root** : Sécurité renforcée
4. **Multi-stage build** : Séparation dev/prod
5. **Health check** : Monitoring de la santé de l'app

## 📦 Contenu

-   `Dockerfile` - Dockerfile optimisé multi-stage
-   `package.json` - Dépendances Node.js
-   `server.js` - Serveur Express simple
-   `.dockerignore` - Exclusions pour le contexte Docker
-   `docker-compose.yml` - Configuration de développement
-   `build.sh` - Script de construction automatisé

## 🚀 Utilisation

```bash
# Construction de l'image
docker build -t nodejs-optimized .

# Exécution
docker run -p 3000:3000 nodejs-optimized

# Ou avec Docker Compose
docker-compose up
```

## 📊 Comparaison des performances

| Version   | Taille | Temps de build | Couches |
| --------- | ------ | -------------- | ------- |
| Basique   | 980MB  | 45s            | 8       |
| Optimisée | 52MB   | 25s            | 6       |

## 🔒 Sécurité

-   Utilisateur non-privilégié
-   Scan des vulnérabilités avec Trivy
-   Variables d'environnement sécurisées
-   Ports non exposés par défaut
