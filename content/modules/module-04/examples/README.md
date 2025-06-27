# Exemples pratiques - Module 4

Ce dossier contient des exemples concrets d'images Docker optimisées pour différents cas d'usage.

## 📁 Structure des exemples

### 1. Node.js Applications

-   `nodejs-basic/` - Application Node.js simple
-   `nodejs-optimized/` - Version optimisée avec Alpine et multi-stage
-   `react-app/` - Application React avec build de production

### 2. Python Applications

-   `python-basic/` - Application Python simple
-   `python-optimized/` - Version optimisée avec Alpine
-   `django-app/` - Application Django complète

### 3. Multi-language

-   `fullstack-app/` - Application avec frontend et backend
-   `microservices/` - Exemple de microservices

### 4. Templates

-   `dockerfile-templates/` - Templates de Dockerfile pour différents langages
-   `compose-examples/` - Exemples Docker Compose

## 🚀 Comment utiliser ces exemples

1. **Copiez** l'exemple qui vous intéresse
2. **Adaptez** les fichiers à votre projet
3. **Testez** la construction : `docker build -t monapp .`
4. **Optimisez** en suivant les bonnes pratiques du cours

## 📚 Ressources supplémentaires

Chaque exemple contient :

-   Un `Dockerfile` commenté
-   Un fichier `.dockerignore` approprié
-   Un `README.md` avec les instructions
-   Des scripts de build et test

---

_Utilisez ces exemples comme base pour vos propres projets Docker !_
