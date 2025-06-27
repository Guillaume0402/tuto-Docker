# 🐳 Module 2 : Images Docker et Dockerfile

**Durée estimée :** 5 heures  
**Niveau :** Débutant/Intermédiaire  
**Prérequis :** Module 1 terminé

## 🎯 Objectifs pédagogiques

À la fin de ce module, vous serez capable de :

-   ✅ **Comprendre** la structure en couches des images Docker
-   ✅ **Créer** vos propres images avec Dockerfile
-   ✅ **Optimiser** la taille et la performance des images
-   ✅ **Gérer** les images localement
-   ✅ **Publier** des images sur un registre

## 📚 Plan du module

### 1. Comprendre les images Docker (60 min)

### 2. Introduction au Dockerfile (90 min)

### 3. Instructions Dockerfile avancées (90 min)

### 4. Optimisation des images (60 min)

### 5. Registres et publication (60 min)

---

## 1. 🏗️ Comprendre les images Docker

### Structure en couches

Les images Docker sont construites en **couches** (layers) empilées les unes sur les autres :

```
┌─────────────────────────┐
│    Application Layer    │  ← Votre app
├─────────────────────────┤
│    Dependencies Layer   │  ← npm, pip, etc.
├─────────────────────────┤
│    Runtime Layer        │  ← Node.js, Python
├─────────────────────────┤
│    Base OS Layer        │  ← Ubuntu, Alpine
└─────────────────────────┘
```

### Avantages du système de couches

#### 🔄 Réutilisation

```bash
# Ces deux images partagent la couche Ubuntu
FROM ubuntu:20.04
# Instructions pour app1...

FROM ubuntu:20.04
# Instructions pour app2...
```

#### 💾 Économie d'espace

```bash
# Une seule copie de la couche Ubuntu sur le disque
docker images
# ubuntu:20.04 utilisée par 5 images = 1 seule copie physique
```

#### ⚡ Cache intelligent

```bash
# Seules les couches modifiées sont reconstruites
# Modif ligne 10 du Dockerfile → reconstruction à partir de la ligne 10
```

### Commandes pour gérer les images

#### Lister les images

```bash
docker images
# ou
docker image ls

# Avec des filtres
docker images nginx
docker images --filter "dangling=true"
```

#### Inspecter une image

```bash
docker inspect nginx:latest
docker history nginx:latest  # Voir les couches
```

#### Supprimer des images

```bash
docker rmi nginx:latest
docker image prune  # Supprimer les images non utilisées
docker image prune -a  # Supprimer toutes les images non utilisées
```

#### Rechercher des images

```bash
docker search nginx
docker search --limit 5 python
```

---

## 2. 📄 Introduction au Dockerfile

### Qu'est-ce qu'un Dockerfile ?

Un **Dockerfile** est un fichier texte contenant une série d'instructions pour construire une image Docker de manière automatisée.

### Structure de base

```dockerfile
# Commentaire
FROM image_de_base
INSTRUCTION argument
INSTRUCTION argument
...
```

### Exemple simple : Hello World personnalisé

```dockerfile
# Dockerfile
FROM alpine:latest
CMD echo "Hello Docker World!"
```

```bash
# Construction
docker build -t mon-hello .

# Exécution
docker run mon-hello
```

### Instructions fondamentales

#### FROM - Image de base

```dockerfile
FROM ubuntu:20.04
FROM node:16-alpine
FROM python:3.9-slim
```

#### RUN - Exécuter des commandes

```dockerfile
RUN apt-get update && apt-get install -y curl
RUN npm install express
RUN pip install flask
```

#### COPY - Copier des fichiers

```dockerfile
COPY app.js /usr/src/app/
COPY package*.json ./
COPY . /app
```

#### ADD - Copier avec fonctionnalités avancées

```dockerfile
ADD https://example.com/file.tar.gz /tmp/
ADD archive.tar.gz /opt/  # Décompression automatique
```

#### WORKDIR - Répertoire de travail

```dockerfile
WORKDIR /usr/src/app
COPY . .
RUN npm install
```

#### CMD - Commande par défaut

```dockerfile
CMD ["npm", "start"]
CMD ["python", "app.py"]
CMD echo "Hello"
```

#### ENTRYPOINT - Point d'entrée

```dockerfile
ENTRYPOINT ["python"]
CMD ["app.py"]
# Équivaut à : python app.py
```

### Exemple concret : Application Node.js

```dockerfile
# Dockerfile pour une app Node.js
FROM node:16-alpine

# Métadonnées
LABEL maintainer="votre-email@example.com"
LABEL version="1.0"
LABEL description="Mon API Node.js"

# Répertoire de travail
WORKDIR /usr/src/app

# Copier les fichiers package
COPY package*.json ./

# Installer les dépendances
RUN npm ci --only=production

# Copier le code source
COPY . .

# Exposer le port
EXPOSE 3000

# Créer un utilisateur non-root
RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001
USER nodejs

# Commande par défaut
CMD ["node", "server.js"]
```

---

## 3. 🔧 Instructions Dockerfile avancées

### ENV - Variables d'environnement

```dockerfile
ENV NODE_ENV=production
ENV PORT=3000
ENV DATABASE_URL=postgresql://localhost:5432/mydb

# Utilisation
EXPOSE $PORT
```

### ARG - Arguments de construction

```dockerfile
ARG NODE_VERSION=16
FROM node:${NODE_VERSION}-alpine

ARG APP_NAME=myapp
LABEL name=${APP_NAME}
```

```bash
# Usage
docker build --build-arg NODE_VERSION=18 -t myapp .
```

### VOLUME - Volumes

```dockerfile
VOLUME ["/data"]
VOLUME ["/var/log", "/var/db"]
```

### HEALTHCHECK - Contrôle de santé

```dockerfile
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD curl -f http://localhost:3000/health || exit 1
```

### Multi-stage builds

```dockerfile
# Stage 1: Build
FROM node:16-alpine AS builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Production
FROM node:16-alpine AS production
WORKDIR /app
COPY --from=builder /app/dist ./dist
COPY --from=builder /app/node_modules ./node_modules
COPY package*.json ./
CMD ["node", "dist/server.js"]
```

### .dockerignore

```bash
# .dockerignore
node_modules
npm-debug.log
Dockerfile
.dockerignore
.git
.gitignore
README.md
.env
coverage
.nyc_output
```

---

## 4. ⚡ Optimisation des images

### Règles d'or pour l'optimisation

#### 1. Utiliser des images de base légères

```dockerfile
# ❌ Lourd (600MB+)
FROM ubuntu:20.04

# ✅ Léger (5MB)
FROM alpine:latest

# ✅ Spécialisé et optimisé
FROM node:16-alpine
```

#### 2. Combiner les commandes RUN

```dockerfile
# ❌ Chaque RUN crée une couche
RUN apt-get update
RUN apt-get install -y curl
RUN apt-get install -y vim

# ✅ Une seule couche
RUN apt-get update && \
    apt-get install -y curl vim && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
```

#### 3. Ordre des instructions

```dockerfile
# ✅ Instructions qui changent peu en premier
FROM node:16-alpine
WORKDIR /app

# Dépendances (changent rarement)
COPY package*.json ./
RUN npm ci --only=production

# Code source (change souvent)
COPY . .

CMD ["npm", "start"]
```

#### 4. Multi-stage pour éliminer les outils de build

```dockerfile
# Stage de build avec tous les outils
FROM node:16-alpine AS builder
WORKDIR /app
COPY package*.json ./
RUN npm ci  # Inclut devDependencies
COPY . .
RUN npm run build

# Stage de production, léger
FROM node:16-alpine AS production
WORKDIR /app
COPY --from=builder /app/dist ./dist
COPY --from=builder /app/node_modules ./node_modules
CMD ["node", "dist/server.js"]
```

### Outils d'analyse

```bash
# Taille des images
docker images

# Historique des couches
docker history mon-image

# Analyse détaillée avec dive
docker run --rm -it \
  -v /var/run/docker.sock:/var/run/docker.sock \
  wagoodman/dive:latest mon-image
```

---

## 5. 🌐 Registres et publication

### Docker Hub

#### Connexion

```bash
docker login
```

#### Tag et push

```bash
# Tag avec votre nom d'utilisateur
docker tag mon-app:latest username/mon-app:latest
docker tag mon-app:latest username/mon-app:v1.0

# Push
docker push username/mon-app:latest
docker push username/mon-app:v1.0
```

### Registres privés

#### Registry Docker local

```bash
# Lancer un registry local
docker run -d -p 5000:5000 --name registry registry:2

# Tag et push
docker tag mon-app localhost:5000/mon-app
docker push localhost:5000/mon-app
```

### Bonnes pratiques pour les tags

```bash
# Versioning sémantique
docker tag mon-app:latest username/mon-app:1.0.0
docker tag mon-app:latest username/mon-app:1.0
docker tag mon-app:latest username/mon-app:1
docker tag mon-app:latest username/mon-app:latest

# Tags par environnement
docker tag mon-app:latest username/mon-app:dev
docker tag mon-app:latest username/mon-app:staging
docker tag mon-app:latest username/mon-app:prod
```

---

## 🧪 Laboratoire pratique

### Projet : API REST avec base de données

Créer une API REST Node.js connectée à MongoDB, optimisée et publiée.

#### Structure du projet

```
mon-api/
├── Dockerfile
├── .dockerignore
├── package.json
├── src/
│   ├── server.js
│   ├── routes/
│   └── models/
└── docker-compose.yml
```

#### Dockerfile optimisé

```dockerfile
FROM node:16-alpine AS builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM node:16-alpine AS production
RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001
WORKDIR /app
COPY --from=builder /app/dist ./dist
COPY --from=builder /app/node_modules ./node_modules
COPY package*.json ./

USER nodejs
EXPOSE 3000
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD wget --no-verbose --tries=1 --spider http://localhost:3000/health || exit 1

CMD ["node", "dist/server.js"]
```

---

## 📝 Résumé du module

### Points clés retenus

1. **Images en couches** : Système intelligent de cache et réutilisation
2. **Dockerfile** : Automatisation de la construction d'images
3. **Optimisation** : Images légères et build efficace
4. **Registres** : Partage et versioning des images
5. **Bonnes pratiques** : Sécurité, performance, maintenabilité

### Commandes essentielles

```bash
# Construction
docker build -t nom-image .
docker build -t nom-image:tag .

# Gestion des images
docker images
docker rmi image-id
docker image prune

# Registres
docker tag image registry/image:tag
docker push registry/image:tag
docker pull registry/image:tag
```

### Pour aller plus loin

-   Module 3 : Volumes et gestion des données
-   Module 4 : Réseau Docker
-   Module 5 : Docker Compose
-   Documentation officielle : https://docs.docker.com/engine/reference/builder/

---

## 🎯 Objectifs du prochain module

Au **Module 3**, nous découvrirons :

-   La gestion des volumes Docker
-   La persistance des données
-   Les différents types de volumes
-   Le partage de données entre conteneurs
