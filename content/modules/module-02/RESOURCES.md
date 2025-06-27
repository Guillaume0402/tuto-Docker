# 📚 Ressources et outils - Module 2

## 🔗 Liens essentiels

### Documentation officielle

-   [Dockerfile Reference](https://docs.docker.com/engine/reference/builder/) - Guide complet des instructions Dockerfile
-   [Best practices for writing Dockerfiles](https://docs.docker.com/develop/dev-best-practices/) - Bonnes pratiques officielles
-   [Docker Hub](https://hub.docker.com/) - Registre public d'images Docker
-   [Multi-stage builds](https://docs.docker.com/develop/dev-best-practices/#use-multi-stage-builds) - Documentation des builds en plusieurs étapes

### Registres d'images

-   [Docker Hub](https://hub.docker.com/) - Registre public principal
-   [GitHub Container Registry](https://docs.github.com/en/packages/working-with-a-github-packages-registry/working-with-the-container-registry) - Registre intégré à GitHub
-   [GitLab Container Registry](https://docs.gitlab.com/ee/user/packages/container_registry/) - Registre GitLab
-   [Amazon ECR](https://aws.amazon.com/ecr/) - Registre AWS
-   [Google Container Registry](https://cloud.google.com/container-registry) - Registre Google Cloud

---

## 🛠️ Outils recommandés

### Analyse et optimisation d'images

#### Dive - Analyser les couches

```bash
# Installation
curl -LO https://github.com/wagoodman/dive/releases/download/v0.10.0/dive_0.10.0_linux_amd64.tar.gz
tar -xzf dive_0.10.0_linux_amd64.tar.gz
sudo mv dive /usr/local/bin/

# Utilisation
dive mon-image:latest
```

#### Docker Slim - Optimisation automatique

```bash
# Installation
curl -sL https://raw.githubusercontent.com/docker-slim/docker-slim/master/scripts/install-dockerslim.sh | sudo -E bash -

# Utilisation
docker-slim build --target mon-image:latest --tag mon-image:slim
```

#### Hadolint - Linter pour Dockerfile

```bash
# Via Docker
docker run --rm -i hadolint/hadolint < Dockerfile

# Installation locale
sudo wget -O /usr/local/bin/hadolint https://github.com/hadolint/hadolint/releases/download/v2.8.0/hadolint-Linux-x86_64
sudo chmod +x /usr/local/bin/hadolint
```

### Sécurité

#### Trivy - Scanner de vulnérabilités

```bash
# Installation
sudo apt-get install wget apt-transport-https gnupg lsb-release
wget -qO - https://aquasecurity.github.io/trivy-repo/deb/public.key | sudo apt-key add -
echo "deb https://aquasecurity.github.io/trivy-repo/deb $(lsb_release -sc) main" | sudo tee -a /etc/apt/sources.list.d/trivy.list
sudo apt-get update
sudo apt-get install trivy

# Scanner une image
trivy image mon-image:latest
```

#### Clair - Analyse statique de sécurité

```bash
# Lancement avec Docker Compose
version: '3'
services:
  clair:
    image: quay.io/coreos/clair:latest
    ports:
      - "6060:6060"
```

---

## 📦 Images de base recommandées

### Pour le développement

#### Alpine Linux (Ultra-léger)

```dockerfile
FROM alpine:latest      # ~5MB
FROM node:16-alpine     # ~110MB
FROM python:3.9-alpine  # ~45MB
FROM golang:1.19-alpine # ~300MB
```

#### Debian Slim (Équilibré)

```dockerfile
FROM debian:bullseye-slim  # ~80MB
FROM node:16-slim          # ~180MB
FROM python:3.9-slim       # ~120MB
```

#### Distroless (Sécurisé)

```dockerfile
FROM gcr.io/distroless/java:11    # Java
FROM gcr.io/distroless/nodejs:16  # Node.js
FROM gcr.io/distroless/python3    # Python
FROM gcr.io/distroless/static     # Binaires statiques
```

### Images spécialisées

#### Bases de données

```dockerfile
FROM postgres:14-alpine    # PostgreSQL léger
FROM mysql:8.0            # MySQL officiel
FROM redis:7-alpine       # Redis léger
FROM mongo:5.0            # MongoDB
```

#### Serveurs web

```dockerfile
FROM nginx:alpine         # Nginx léger
FROM httpd:alpine         # Apache léger
FROM caddy:alpine         # Caddy server
```

---

## 📝 Templates et exemples

### Template Dockerfile Node.js optimisé

```dockerfile
# Multi-stage build pour application Node.js
FROM node:16-alpine AS builder

# Métadonnées
LABEL maintainer="votre@email.com"
LABEL version="1.0.0"
LABEL description="Application Node.js optimisée"

# Répertoire de travail
WORKDIR /app

# Copier les fichiers de dépendances
COPY package*.json ./

# Installer les dépendances
RUN npm ci --only=production && npm cache clean --force

# Copier le code source
COPY . .

# Build de l'application (si nécessaire)
RUN npm run build

# Stage de production
FROM node:16-alpine AS production

# Créer un utilisateur non-root
RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001

# Répertoire de travail
WORKDIR /app

# Copier depuis le builder
COPY --from=builder --chown=nodejs:nodejs /app/node_modules ./node_modules
COPY --from=builder --chown=nodejs:nodejs /app/dist ./dist
COPY --from=builder --chown=nodejs:nodejs /app/package*.json ./

# Changer vers l'utilisateur non-root
USER nodejs

# Exposer le port
EXPOSE 3000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget --no-verbose --tries=1 --spider http://localhost:3000/health || exit 1

# Commande par défaut
CMD ["node", "dist/server.js"]
```

### Template Dockerfile Python optimisé

```dockerfile
# Multi-stage build pour application Python
FROM python:3.9-slim AS builder

# Variables d'environnement
ENV PYTHONDONTWRITEBYTECODE=1
ENV PYTHONUNBUFFERED=1

# Répertoire de travail
WORKDIR /app

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Copier les requirements
COPY requirements.txt .

# Installer les dépendances Python
RUN pip install --no-cache-dir --user -r requirements.txt

# Stage de production
FROM python:3.9-slim AS production

# Variables d'environnement
ENV PYTHONDONTWRITEBYTECODE=1
ENV PYTHONUNBUFFERED=1
ENV PATH=/home/appuser/.local/bin:$PATH

# Créer un utilisateur non-root
RUN useradd --create-home --shell /bin/bash appuser

# Répertoire de travail
WORKDIR /app

# Copier les dépendances installées
COPY --from=builder /root/.local /home/appuser/.local

# Copier le code source
COPY --chown=appuser:appuser . .

# Changer vers l'utilisateur non-root
USER appuser

# Exposer le port
EXPOSE 8000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD python -c "import requests; requests.get('http://localhost:8000/health')" || exit 1

# Commande par défaut
CMD ["python", "app.py"]
```

### Template .dockerignore

```
# Fichiers Git
.git
.gitignore
.gitattributes

# Fichiers de build
node_modules
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Environnements
.env
.env.local
.env.development.local
.env.test.local
.env.production.local

# Logs
logs
*.log

# Dépendances Python
__pycache__
*.pyc
*.pyo
*.pyd
.Python
build
develop-eggs
dist
downloads
eggs
.eggs
lib
lib64
parts
sdist
var
wheels
*.egg-info
.installed.cfg
*.egg

# IDE
.vscode
.idea
*.swp
*.swo
*~

# OS
.DS_Store
Thumbs.db

# Documentation
README.md
CHANGELOG.md
docs/

# Tests
coverage
.nyc_output
.coverage
htmlcov
.tox
.pytest_cache

# Docker
Dockerfile*
docker-compose*
.dockerignore
```

---

## 🔧 Scripts utiles

### Script de nettoyage Docker

```bash
#!/bin/bash
# clean-docker.sh

echo "🧹 Nettoyage Docker..."

# Supprimer les conteneurs arrêtés
echo "Suppression des conteneurs arrêtés..."
docker container prune -f

# Supprimer les images non utilisées
echo "Suppression des images non utilisées..."
docker image prune -a -f

# Supprimer les volumes non utilisés
echo "Suppression des volumes non utilisés..."
docker volume prune -f

# Supprimer les réseaux non utilisés
echo "Suppression des réseaux non utilisés..."
docker network prune -f

# Supprimer le cache de build
echo "Suppression du cache de build..."
docker builder prune -f

echo "✅ Nettoyage terminé !"
docker system df
```

### Script d'analyse d'image

```bash
#!/bin/bash
# analyze-image.sh

if [ $# -eq 0 ]; then
    echo "Usage: $0 <nom-image>"
    exit 1
fi

IMAGE=$1

echo "🔍 Analyse de l'image: $IMAGE"
echo "================================"

# Informations générales
echo "📊 Informations générales:"
docker inspect $IMAGE --format='{{.RepoTags}} - {{.Size}} bytes'

# Historique des couches
echo -e "\n📋 Historique des couches:"
docker history $IMAGE --format "table {{.CreatedBy}}\t{{.Size}}"

# Vulnérabilités (si Trivy est installé)
if command -v trivy &> /dev/null; then
    echo -e "\n🔒 Analyse de sécurité:"
    trivy image --severity HIGH,CRITICAL $IMAGE
fi

# Configuration
echo -e "\n⚙️  Configuration:"
docker inspect $IMAGE --format='{{.Config.Cmd}} {{.Config.Entrypoint}}'
```

---

## 📚 Lectures recommandées

### Livres

-   **"Docker Deep Dive"** par Nigel Poulton
-   **"Docker in Action"** par Jeff Nickoloff
-   **"Building Microservices"** par Sam Newman

### Articles et blogs

-   [Docker Blog](https://www.docker.com/blog/)
-   [Container Journal](https://containerjournal.com/)
-   [The New Stack - Containers](https://thenewstack.io/category/containers/)

### Formations en ligne

-   [Docker Mastery](https://www.udemy.com/course/docker-mastery/) (Udemy)
-   [Docker for Developers](https://www.pluralsight.com/courses/docker-developers) (Pluralsight)
-   [Introduction to Containers](https://www.edx.org/course/introduction-to-containers) (edX)

---

## 🎯 Checklists de validation

### Dockerfile Quality Checklist

-   [ ] Utilise une image de base officielle et légère
-   [ ] Instructions ordonnées des plus stables aux plus changeantes
-   [ ] Combine les commandes RUN quand possible
-   [ ] Utilise .dockerignore pour exclure les fichiers inutiles
-   [ ] Définit un utilisateur non-root
-   [ ] Inclut des métadonnées avec LABEL
-   [ ] Expose les ports avec EXPOSE
-   [ ] Définit un health check si applicable
-   [ ] Nettoie les caches et fichiers temporaires
-   [ ] Utilise multi-stage si nécessaire

### Production Readiness Checklist

-   [ ] Image scannée pour les vulnérabilités
-   [ ] Taille d'image optimisée (< 500MB pour la plupart des apps)
-   [ ] Logs dirigés vers stdout/stderr
-   [ ] Configuration externalisée (variables d'environnement)
-   [ ] Graceful shutdown implémenté
-   [ ] Monitoring et métriques disponibles
-   [ ] Documentation complète et à jour
-   [ ] Tests d'intégration automatisés
-   [ ] Processus de déploiement automatisé
-   [ ] Stratégie de rollback définie

---

## 🤝 Communauté et support

### Forums et communautés

-   [Docker Community Forums](https://forums.docker.com/)
-   [Reddit r/docker](https://www.reddit.com/r/docker/)
-   [Stack Overflow - Docker](https://stackoverflow.com/questions/tagged/docker)
-   [Discord Docker Community](https://discord.gg/docker)

### Contribuer

-   [Docker Open Source](https://github.com/docker)
-   [Awesome Docker](https://github.com/veggiemonk/awesome-docker)
-   [Docker Samples](https://github.com/dockersamples)

Cette liste de ressources vous accompagnera tout au long de votre apprentissage Docker ! 🚀
