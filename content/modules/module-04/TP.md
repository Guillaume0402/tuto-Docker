# TP Module 4 : Création et Optimisation d'Images Docker

## 🎯 Objectifs du TP

-   Créer votre première image Docker personnalisée
-   Optimiser une image existante
-   Utiliser les multi-stage builds
-   Publier une image sur Docker Hub

## ⏱️ Durée estimée : 45 minutes

---

## 📝 Exercice 1 : Première image avec une application Node.js

### Étape 1 : Préparation du projet

Créez un dossier pour votre première application :

```bash
mkdir tp-docker-images
cd tp-docker-images
mkdir node-app
cd node-app
```

### Étape 2 : Application Node.js simple

Créez le fichier `package.json` :

```json
{
    "name": "docker-node-app",
    "version": "1.0.0",
    "description": "Mon première app Docker",
    "main": "server.js",
    "scripts": {
        "start": "node server.js"
    },
    "dependencies": {
        "express": "^4.18.0"
    }
}
```

Créez le fichier `server.js` :

```javascript
const express = require("express");
const app = express();
const port = 3000;

app.get("/", (req, res) => {
    res.json({
        message: "Hello Docker! 🐳",
        timestamp: new Date().toISOString(),
        version: "1.0.0",
    });
});

app.get("/health", (req, res) => {
    res.json({ status: "OK", uptime: process.uptime() });
});

app.listen(port, "0.0.0.0", () => {
    console.log(`🚀 App running on port ${port}`);
});
```

### Étape 3 : Premier Dockerfile (non optimisé)

Créez le fichier `Dockerfile` :

```dockerfile
FROM node:18
WORKDIR /app
COPY . .
RUN npm install
EXPOSE 3000
CMD ["npm", "start"]
```

### Étape 4 : Construction et test

```bash
# Construire l'image
docker build -t node-app:v1 .

# Vérifier la taille
docker images node-app:v1

# Tester l'application
docker run -p 3000:3000 node-app:v1
```

Visitez http://localhost:3000 pour vérifier que l'app fonctionne.

**Question** : Quelle est la taille de votre image ? Noter cette valeur.

---

## 🔧 Exercice 2 : Optimisation de l'image

### Étape 1 : Dockerfile optimisé

Créez un nouveau fichier `Dockerfile.optimized` :

```dockerfile
FROM node:18-alpine
WORKDIR /app

# Copier seulement les fichiers de dépendances d'abord
COPY package*.json ./
RUN npm ci --only=production

# Copier le code source
COPY server.js ./

# Utilisateur non-root pour la sécurité
RUN addgroup -g 1001 -S nodejs
RUN adduser -S nodeuser -u 1001
USER nodeuser

EXPOSE 3000
CMD ["node", "server.js"]
```

### Étape 2 : Fichier .dockerignore

Créez le fichier `.dockerignore` :

```
node_modules
npm-debug.log
.git
.env
*.md
Dockerfile*
```

### Étape 3 : Construction et comparaison

```bash
# Construire la version optimisée
docker build -f Dockerfile.optimized -t node-app:v2 .

# Comparer les tailles
docker images | grep node-app
```

**Question** : Combien d'espace avez-vous économisé ?

---

## 🏗️ Exercice 3 : Multi-stage build

### Étape 1 : Application avec étape de build

Créez un dossier pour une app React :

```bash
cd ..
mkdir react-app
cd react-app
```

Créez `package.json` :

```json
{
    "name": "react-docker-app",
    "version": "1.0.0",
    "private": true,
    "dependencies": {
        "react": "^18.2.0",
        "react-dom": "^18.2.0",
        "react-scripts": "5.0.1"
    },
    "scripts": {
        "start": "react-scripts start",
        "build": "react-scripts build",
        "test": "react-scripts test",
        "eject": "react-scripts eject"
    },
    "browserslist": {
        "production": [">0.2%", "not dead", "not op_mini all"],
        "development": [
            "last 1 chrome version",
            "last 1 firefox version",
            "last 1 safari version"
        ]
    }
}
```

Créez le dossier `public` et `public/index.html` :

```html
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>React Docker App</title>
    </head>
    <body>
        <div id="root"></div>
    </body>
</html>
```

Créez le dossier `src` et `src/index.js` :

```javascript
import React from "react";
import ReactDOM from "react-dom/client";

function App() {
    return (
        <div style={{ padding: "20px", textAlign: "center" }}>
            <h1>🐳 React + Docker</h1>
            <p>Application React construite avec Docker multi-stage!</p>
            <p>Build time: {new Date().toLocaleString()}</p>
        </div>
    );
}

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);
```

### Étape 2 : Dockerfile multi-stage

Créez le `Dockerfile` :

```dockerfile
# Étape 1: Construction de l'application
FROM node:18-alpine AS builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Étape 2: Serveur de production
FROM nginx:alpine
COPY --from=builder /app/build /usr/share/nginx/html

# Configuration Nginx personnalisée (optionnel)
RUN echo 'server { \
    listen 80; \
    location / { \
        root /usr/share/nginx/html; \
        index index.html index.htm; \
        try_files $uri $uri/ /index.html; \
    } \
}' > /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
```

### Étape 3 : Construction et test

```bash
# Construire l'image multi-stage
docker build -t react-app:multistage .

# Vérifier la taille
docker images react-app:multistage

# Tester l'application
docker run -p 8080:80 react-app:multistage
```

Visitez http://localhost:8080

**Question** : Comparez la taille de cette image avec ce qu'elle aurait été sans multi-stage.

---

## 🌐 Exercice 4 : Publication sur Docker Hub

### Étape 1 : Préparation

1. Créez un compte gratuit sur [Docker Hub](https://hub.docker.com/)
2. Connectez-vous depuis votre terminal :

```bash
docker login
```

### Étape 2 : Tag et push

```bash
# Remplacez 'votre-username' par votre nom d'utilisateur Docker Hub
docker tag node-app:v2 votre-username/mon-premier-app:latest
docker tag node-app:v2 votre-username/mon-premier-app:1.0.0

# Pousser l'image
docker push votre-username/mon-premier-app:latest
docker push votre-username/mon-premier-app:1.0.0
```

### Étape 3 : Test de téléchargement

```bash
# Supprimer l'image locale
docker rmi votre-username/mon-premier-app:latest

# La retélécharger
docker pull votre-username/mon-premier-app:latest

# La tester
docker run -p 3001:3000 votre-username/mon-premier-app:latest
```

---

## 🧪 Exercice 5 : Analyse et debugging

### Étape 1 : Inspection d'une image

```bash
# Voir les couches d'une image
docker history node-app:v2

# Inspecter les métadonnées
docker inspect node-app:v2

# Voir les fichiers dans l'image
docker run --rm -it node-app:v2 sh
ls -la
exit
```

### Étape 2 : Debugging d'un conteneur

```bash
# Lancer un conteneur en mode interactif
docker run -it node-app:v2 sh

# Ou se connecter à un conteneur en cours d'exécution
docker exec -it container_name sh
```

---

## 📊 Résultats attendus

À la fin de ce TP, vous devriez avoir :

1. **Une image Node.js basique** (~1GB)
2. **Une image Node.js optimisée** (~100-200MB)
3. **Une image React multi-stage** (~20-50MB)
4. **Une image publiée sur Docker Hub**

### Comparaison des tailles :

-   Image non optimisée : ~1000MB
-   Image optimisée (Alpine) : ~150MB
-   Image multi-stage : ~25MB

## 🎯 Points clés à retenir

1. **L'ordre des couches** impacte le cache et la vitesse de construction
2. **Les images Alpine** sont beaucoup plus légères
3. **Multi-stage builds** permettent de séparer construction et production
4. **`.dockerignore`** évite de copier des fichiers inutiles
5. **La sécurité** : utiliser des utilisateurs non-root

## 🚀 Défis bonus

1. **Sécurité** : Scannez vos images avec `docker scan`
2. **Automatisation** : Créez un script bash pour automatiser le build
3. **CI/CD** : Intégrez la construction dans GitHub Actions
4. **Monitoring** : Ajoutez des health checks à vos images

---

## 📋 Questions de révision

1. Quelle est la différence entre `COPY` et `ADD` ?
2. Pourquoi utiliser `npm ci` plutôt que `npm install` ?
3. Comment réduire le nombre de couches dans une image ?
4. Quand utiliser `CMD` vs `ENTRYPOINT` ?
5. Pourquoi les multi-stage builds sont-ils utiles ?

---

_Excellent travail ! Vous maîtrisez maintenant la création et l'optimisation d'images Docker. Passez au quiz pour valider vos connaissances !_
