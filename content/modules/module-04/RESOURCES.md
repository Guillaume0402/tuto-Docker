# Module 4 - Ressources : Images Docker

## 📚 Documentation officielle

-   [Dockerfile Reference](https://docs.docker.com/engine/reference/builder/) - Référence complète des instructions Dockerfile
-   [Best practices for writing Dockerfiles](https://docs.docker.com/develop/dev-best-practices/) - Guide officiel des bonnes pratiques
-   [Multi-stage builds](https://docs.docker.com/develop/dev-best-practices/) - Documentation sur les constructions multi-étapes

## 🛠️ Outils utiles

### Analyse et optimisation d'images

-   [Dive](https://github.com/wagoodman/dive) - Analyser et optimiser les images Docker
-   [Docker Slim](https://github.com/docker-slim/docker-slim) - Réduire automatiquement la taille des images
-   [Hadolint](https://github.com/hadolint/hadolint) - Linter pour Dockerfile

### Sécurité

-   [Docker Bench Security](https://github.com/docker/docker-bench-security) - Script de sécurité Docker
-   [Trivy](https://github.com/aquasecurity/trivy) - Scanner de vulnérabilités
-   [Anchore](https://anchore.com/) - Analyse de sécurité des conteneurs

## 📖 Guides et tutoriels

-   [Docker Image Best Practices](https://docs.docker.com/develop/dev-best-practices/) - Bonnes pratiques officielles
-   [Optimizing Docker Images](https://blog.docker.com/2019/07/intro-guide-to-dockerfile-best-practices/) - Guide d'optimisation
-   [Security Best Practices](https://docs.docker.com/engine/security/) - Sécurité des conteneurs

## 🎥 Ressources vidéo

-   [Docker Images Deep Dive](https://www.youtube.com/watch?v=Ko2PyuQ5-3c) - Compréhension approfondie des images
-   [Multi-stage Builds Explained](https://www.youtube.com/watch?v=zpkqNPwEzac) - Explication des builds multi-étapes

## 📦 Images de base recommandées

### Langages de programmation

```dockerfile
# Node.js
FROM node:18-alpine
FROM node:18-slim

# Python
FROM python:3.11-alpine
FROM python:3.11-slim

# Java
FROM openjdk:17-alpine
FROM eclipse-temurin:17-alpine

# Go
FROM golang:1.20-alpine AS builder
FROM alpine:latest  # pour le runtime

# .NET
FROM mcr.microsoft.com/dotnet/aspnet:7.0-alpine
```

### Serveurs web

```dockerfile
# Nginx
FROM nginx:alpine

# Apache
FROM httpd:alpine

# Traefik
FROM traefik:latest
```

### Bases de données

```dockerfile
# PostgreSQL
FROM postgres:15-alpine

# MySQL
FROM mysql:8.0

# Redis
FROM redis:alpine

# MongoDB
FROM mongo:latest
```

## 🔧 Exemples de Dockerfiles optimisés

### Application Node.js Production

```dockerfile
FROM node:18-alpine AS base
WORKDIR /app
RUN addgroup -g 1001 -S nodejs
RUN adduser -S nodeuser -u 1001

FROM base AS deps
COPY package*.json ./
RUN npm ci --only=production

FROM base AS build
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM base AS runtime
COPY --from=deps /app/node_modules ./node_modules
COPY --from=build /app/dist ./dist
COPY --from=build /app/package.json ./package.json

USER nodeuser
EXPOSE 3000
CMD ["npm", "start"]
```

### Application Python avec Poetry

```dockerfile
FROM python:3.11-slim as base

ENV PYTHONUNBUFFERED=1 \
    PYTHONDONTWRITEBYTECODE=1 \
    PIP_NO_CACHE_DIR=1 \
    PIP_DISABLE_PIP_VERSION_CHECK=1

FROM base as builder
RUN pip install poetry
WORKDIR /app
COPY pyproject.toml poetry.lock ./
RUN poetry config virtualenvs.create false \
    && poetry install --only=main --no-root

FROM base as runtime
WORKDIR /app
COPY --from=builder /usr/local/lib/python3.11/site-packages /usr/local/lib/python3.11/site-packages
COPY . .
RUN adduser --disabled-password --gecos '' appuser
USER appuser
CMD ["python", "app.py"]
```

## 📋 Templates .dockerignore

### Pour Node.js

```
node_modules
npm-debug.log*
yarn-debug.log*
yarn-error.log*
.npm
.env.local
.env.development.local
.env.test.local
.env.production.local
.git
.gitignore
README.md
Dockerfile*
docker-compose*
```

### Pour Python

```
__pycache__
*.pyc
*.pyo
*.pyd
.Python
env
pip-log.txt
pip-delete-this-directory.txt
.tox
.coverage
.coverage.*
.cache
nosetests.xml
coverage.xml
*.cover
*.log
.git
.mypy_cache
.pytest_cache
.hypothesis
```

## 🧪 Scripts utiles

### Script de build automatisé

```bash
#!/bin/bash
# build.sh

APP_NAME="myapp"
VERSION=$(git describe --tags --always --dirty)
REGISTRY="your-registry.com"

echo "Building ${APP_NAME}:${VERSION}..."

# Build de l'image
docker build \
    --tag ${APP_NAME}:${VERSION} \
    --tag ${APP_NAME}:latest \
    --tag ${REGISTRY}/${APP_NAME}:${VERSION} \
    --tag ${REGISTRY}/${APP_NAME}:latest \
    .

# Afficher la taille
echo "Image size:"
docker images ${APP_NAME}:${VERSION}

# Scanner les vulnérabilités
echo "Scanning for vulnerabilities..."
docker scan ${APP_NAME}:${VERSION}

echo "Build completed!"
```

### Script d'analyse d'image

```bash
#!/bin/bash
# analyze.sh

IMAGE_NAME=$1

if [ -z "$IMAGE_NAME" ]; then
    echo "Usage: $0 <image-name>"
    exit 1
fi

echo "Analyzing image: $IMAGE_NAME"
echo "================================"

echo "Image size:"
docker images $IMAGE_NAME

echo -e "\nImage layers:"
docker history $IMAGE_NAME

echo -e "\nImage inspection:"
docker inspect $IMAGE_NAME | jq '.[]|{Architecture,Os,Size,VirtualSize}'

echo -e "\nRunning dive analysis..."
dive $IMAGE_NAME
```

## 🔒 Configuration de sécurité

### Exemple d'utilisateur non-root

```dockerfile
# Créer un utilisateur non-privilégié
RUN groupadd -r appgroup && useradd -r -g appgroup appuser

# Ou pour Alpine
RUN addgroup -g 1001 -S appgroup && \
    adduser -u 1001 -S appuser -G appgroup

# Changer les permissions si nécessaire
RUN chown -R appuser:appgroup /app

# Basculer vers l'utilisateur
USER appuser
```

### Scan de sécurité avec Trivy

```bash
# Installation de Trivy
curl -sfL https://raw.githubusercontent.com/aquasecurity/trivy/main/contrib/install.sh | sh -s -- -b /usr/local/bin

# Scan d'une image
trivy image myapp:latest

# Scan avec rapport JSON
trivy image --format json -o report.json myapp:latest
```

## 📊 Monitoring et métriques

### Health checks

```dockerfile
# Health check simple
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:3000/health || exit 1

# Health check avec script custom
COPY healthcheck.sh /usr/local/bin/
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD healthcheck.sh
```

### Labels pour métadonnées

```dockerfile
LABEL org.opencontainers.image.title="Mon Application"
LABEL org.opencontainers.image.description="Description de l'application"
LABEL org.opencontainers.image.version="1.0.0"
LABEL org.opencontainers.image.authors="votre@email.com"
LABEL org.opencontainers.image.source="https://github.com/user/repo"
LABEL org.opencontainers.image.documentation="https://docs.example.com"
```

## 🚀 CI/CD avec GitHub Actions

### Workflow de build et push

```yaml
name: Build and Push Docker Image

on:
    push:
        branches: [main]
        tags: ["v*"]

jobs:
    build:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v3

            - name: Set up Docker Buildx
              uses: docker/setup-buildx-action@v2

            - name: Login to DockerHub
              uses: docker/login-action@v2
              with:
                  username: ${{ secrets.DOCKERHUB_USERNAME }}
                  password: ${{ secrets.DOCKERHUB_TOKEN }}

            - name: Build and push
              uses: docker/build-push-action@v4
              with:
                  context: .
                  push: true
                  tags: |
                      myapp:latest
                      myapp:${{ github.sha }}
                  cache-from: type=gha
                  cache-to: type=gha,mode=max
```

---

_Ces ressources vous donneront tous les outils nécessaires pour créer des images Docker professionnelles, sécurisées et optimisées !_
