# 🛠️ Travaux Pratiques - Module 2

## TP1 : Première image personnalisée

### Objectif

Créer votre première image Docker personnalisée et comprendre le processus de build.

### Scenario

Vous devez créer une image qui affiche des informations système personnalisées.

### Instructions

1. **Création du projet**

    ```bash
    mkdir tp-docker-images
    cd tp-docker-images
    ```

2. **Script d'information système**
   Créer un fichier `info.sh` :

    ```bash
    #!/bin/bash
    echo "=== INFORMATIONS SYSTÈME ==="
    echo "Hostname: $(hostname)"
    echo "Date: $(date)"
    echo "Utilisateur: $(whoami)"
    echo "Répertoire: $(pwd)"
    echo "Distribution: $(cat /etc/os-release | grep PRETTY_NAME)"
    echo "Processus: $(ps aux | wc -l)"
    echo "==========================="
    ```

3. **Dockerfile**

    ```dockerfile
    FROM alpine:latest

    # Installer bash
    RUN apk add --no-cache bash

    # Copier le script
    COPY info.sh /usr/local/bin/info.sh
    RUN chmod +x /usr/local/bin/info.sh

    # Commande par défaut
    CMD ["/usr/local/bin/info.sh"]
    ```

4. **Construction et test**
    ```bash
    docker build -t mon-info:v1 .
    docker run mon-info:v1
    ```

### Questions

1. Combien de couches a votre image ?
2. Quelle est la taille finale de l'image ?
3. Que se passe-t-il si vous reconstruisez sans modifier les fichiers ?

---

## TP2 : Application web Node.js

### Objectif

Créer une image pour une application web complète avec optimisations.

### Scenario

Développer une API REST simple avec Express.js et l'empaqueter dans Docker.

### Instructions

1. **Initialisation du projet**

    ```bash
    mkdir api-express
    cd api-express
    npm init -y
    npm install express cors helmet
    ```

2. **Code de l'application**
   Créer `server.js` :

    ```javascript
    const express = require("express");
    const cors = require("cors");
    const helmet = require("helmet");
    const app = express();

    app.use(helmet());
    app.use(cors());
    app.use(express.json());

    // Routes
    app.get("/health", (req, res) => {
        res.json({ status: "OK", timestamp: new Date().toISOString() });
    });

    app.get("/api/users", (req, res) => {
        const users = [
            { id: 1, name: "Alice", email: "alice@example.com" },
            { id: 2, name: "Bob", email: "bob@example.com" },
            { id: 3, name: "Charlie", email: "charlie@example.com" },
        ];
        res.json(users);
    });

    app.get("/api/stats", (req, res) => {
        res.json({
            uptime: process.uptime(),
            memory: process.memoryUsage(),
            version: process.version,
            platform: process.platform,
        });
    });

    const PORT = process.env.PORT || 3000;
    app.listen(PORT, "0.0.0.0", () => {
        console.log(`🚀 API démarrée sur le port ${PORT}`);
    });
    ```

3. **Dockerfile optimisé**

    ```dockerfile
    # Multi-stage build
    FROM node:16-alpine AS builder

    WORKDIR /app

    # Copier package.json et package-lock.json
    COPY package*.json ./

    # Installer toutes les dépendances (dev + prod)
    RUN npm ci

    # Copier le code source
    COPY . .

    # Stage de production
    FROM node:16-alpine AS production

    # Créer un utilisateur non-root
    RUN addgroup -g 1001 -S nodejs && \
        adduser -S nodejs -u 1001

    WORKDIR /app

    # Copier seulement les node_modules de production
    COPY --from=builder /app/node_modules ./node_modules
    COPY --from=builder /app/package*.json ./
    COPY --from=builder /app/server.js ./

    # Changer vers l'utilisateur non-root
    USER nodejs

    # Exposer le port
    EXPOSE 3000

    # Health check
    HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
      CMD wget --no-verbose --tries=1 --spider http://localhost:3000/health || exit 1

    # Commande par défaut
    CMD ["node", "server.js"]
    ```

4. **Fichier .dockerignore**

    ```
    node_modules
    npm-debug.log
    .git
    .gitignore
    README.md
    .env
    .nyc_output
    coverage
    .DS_Store
    Dockerfile
    .dockerignore
    ```

5. **Construction et test**

    ```bash
    # Build
    docker build -t api-express:latest .
    docker build -t api-express:v1.0 .

    # Run
    docker run -d -p 3000:3000 --name mon-api api-express:latest

    # Test
    curl http://localhost:3000/health
    curl http://localhost:3000/api/users
    curl http://localhost:3000/api/stats

    # Logs
    docker logs mon-api

    # Clean up
    docker stop mon-api
    docker rm mon-api
    ```

### Défis bonus

1. Ajouter une route POST pour créer des utilisateurs
2. Implémenter la validation des données
3. Ajouter des tests avec Jest
4. Créer un stage de test dans le Dockerfile

---

## TP3 : Optimisation comparative

### Objectif

Comparer différentes approches de construction d'images et mesurer les performances.

### Scenario

Créer la même application avec 3 approches différentes et comparer les résultats.

### Instructions

1. **Approche 1 : Image Ubuntu classique**

    ```dockerfile
    FROM ubuntu:20.04

    RUN apt-get update
    RUN apt-get install -y nodejs npm

    WORKDIR /app
    COPY . .
    RUN npm install

    CMD ["node", "server.js"]
    ```

2. **Approche 2 : Image Node.js optimisée**

    ```dockerfile
    FROM node:16-alpine

    WORKDIR /app
    COPY package*.json ./
    RUN npm ci --only=production
    COPY . .

    USER node
    CMD ["node", "server.js"]
    ```

3. **Approche 3 : Multi-stage avec distroless**

    ```dockerfile
    FROM node:16-alpine AS builder
    WORKDIR /app
    COPY package*.json ./
    RUN npm ci --only=production
    COPY . .

    FROM gcr.io/distroless/nodejs:16
    WORKDIR /app
    COPY --from=builder /app .
    CMD ["server.js"]
    ```

4. **Comparaison**

    ```bash
    # Build toutes les versions
    docker build -f Dockerfile.ubuntu -t app-ubuntu .
    docker build -f Dockerfile.alpine -t app-alpine .
    docker build -f Dockerfile.distroless -t app-distroless .

    # Comparer les tailles
    docker images | grep app-

    # Temps de démarrage
    time docker run --rm app-ubuntu echo "Ready"
    time docker run --rm app-alpine echo "Ready"
    time docker run --rm app-distroless echo "Ready"
    ```

5. **Analyse des couches**
    ```bash
    docker history app-ubuntu
    docker history app-alpine
    docker history app-distroless
    ```

### Métriques à comparer

-   Taille de l'image
-   Temps de construction
-   Temps de démarrage
-   Nombre de couches
-   Vulnérabilités de sécurité

---

## TP4 : Publication sur Docker Hub

### Objectif

Publier vos images sur Docker Hub et gérer les versions.

### Prérequis

-   Compte Docker Hub gratuit
-   Image créée dans les TP précédents

### Instructions

1. **Connexion à Docker Hub**

    ```bash
    docker login
    ```

2. **Tag des images**

    ```bash
    # Remplacez 'votrenom' par votre nom d'utilisateur Docker Hub
    docker tag api-express:latest votrenom/api-express:latest
    docker tag api-express:latest votrenom/api-express:v1.0.0
    docker tag api-express:latest votrenom/api-express:alpine
    ```

3. **Push vers Docker Hub**

    ```bash
    docker push votrenom/api-express:latest
    docker push votrenom/api-express:v1.0.0
    docker push votrenom/api-express:alpine
    ```

4. **Vérification**

    - Aller sur https://hub.docker.com
    - Vérifier que vos images sont visibles
    - Tester le pull depuis un autre environnement

5. **Test de pull**

    ```bash
    # Supprimer les images locales
    docker rmi votrenom/api-express:latest
    docker rmi votrenom/api-express:v1.0.0

    # Re-télécharger depuis Docker Hub
    docker pull votrenom/api-express:latest
    docker run -p 3000:3000 votrenom/api-express:latest
    ```

6. **Documentation sur Docker Hub**
    - Ajouter une description
    - Inclure les instructions d'utilisation
    - Ajouter des tags appropriés

### Bonnes pratiques de publication

1. Toujours inclure un tag `latest`
2. Utiliser le versioning sémantique (v1.0.0, v1.1.0)
3. Documenter l'utilisation dans la description
4. Tester l'image après publication
5. Maintenir un changelog

---

## TP5 : Registry privé local

### Objectif

Mettre en place et utiliser un registry Docker privé local.

### Scenario

Votre entreprise veut héberger ses propres images Docker pour des raisons de sécurité.

### Instructions

1. **Lancement du registry**

    ```bash
    docker run -d -p 5000:5000 --name registry \
      -v registry-data:/var/lib/registry \
      registry:2
    ```

2. **Configuration avec authentification (optionnel)**

    ```bash
    # Créer un répertoire pour l'auth
    mkdir auth

    # Générer un fichier de mot de passe
    docker run --entrypoint htpasswd registry:2 \
      -Bbn admin password > auth/htpasswd

    # Relancer avec auth
    docker stop registry
    docker rm registry

    docker run -d -p 5000:5000 --name registry \
      -v registry-data:/var/lib/registry \
      -v $(pwd)/auth:/auth \
      -e "REGISTRY_AUTH=htpasswd" \
      -e "REGISTRY_AUTH_HTPASSWD_REALM=Registry Realm" \
      -e "REGISTRY_AUTH_HTPASSWD_PATH=/auth/htpasswd" \
      registry:2
    ```

3. **Push vers le registry privé**

    ```bash
    # Tag avec l'adresse du registry local
    docker tag api-express:latest localhost:5000/api-express:latest
    docker tag api-express:latest localhost:5000/api-express:v1.0

    # Push
    docker push localhost:5000/api-express:latest
    docker push localhost:5000/api-express:v1.0
    ```

4. **Vérification et pull**

    ```bash
    # Lister les images du registry
    curl http://localhost:5000/v2/_catalog
    curl http://localhost:5000/v2/api-express/tags/list

    # Supprimer l'image locale et la re-télécharger
    docker rmi localhost:5000/api-express:latest
    docker pull localhost:5000/api-express:latest
    ```

5. **Interface web (optionnel)**
    ```bash
    docker run -d -p 8080:8080 --name registry-ui \
      -e REGISTRY_URL=http://localhost:5000 \
      joxit/docker-registry-ui:static
    ```
    Accéder à http://localhost:8080

### Questions

1. Quels sont les avantages d'un registry privé ?
2. Comment sécuriser un registry en production ?
3. Comment gérer les quotas et la rétention ?

---

## 🎯 Validation des compétences

### Checklist de validation

-   [ ] J'ai créé une image personnalisée fonctionnelle
-   [ ] J'ai optimisé une image (multi-stage, alpine, .dockerignore)
-   [ ] J'ai publié une image sur Docker Hub
-   [ ] J'ai configuré un registry privé local
-   [ ] Je comprends la structure en couches des images
-   [ ] Je maîtrise les instructions Dockerfile essentielles
-   [ ] J'ai comparé différentes approches d'optimisation

### Projet final

Créer une application web complète (frontend + backend + base) avec :

-   Images optimisées pour chaque composant
-   Multi-stage builds
-   Publication sur registry privé
-   Documentation complète
-   Health checks fonctionnels

### Ressources complémentaires

-   [Dockerfile best practices](https://docs.docker.com/develop/dev-best-practices/)
-   [Docker Hub](https://hub.docker.com)
-   [Harbor Registry](https://goharbor.io/)
-   [Dive - Analyser les couches](https://github.com/wagoodman/dive)
