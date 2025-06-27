# 🎯 Quiz d'évaluation - Module 2

## Questions à choix multiples (QCM)

### Question 1

**Quelle est la principale caractéristique du système de couches des images Docker ?**

a) Chaque couche est complètement indépendante des autres  
b) Les couches sont empilées et peuvent être réutilisées entre différentes images  
c) Une image ne peut avoir qu'une seule couche  
d) Les couches ne peuvent pas être mises en cache

<details>
<summary>Réponse</summary>

**b) Les couches sont empilées et peuvent être réutilisées entre différentes images**

Le système de couches permet la réutilisation et le cache. Si plusieurs images utilisent la même couche de base (ex: Ubuntu), une seule copie est stockée sur le disque.

</details>

---

### Question 2

**Quelle est la différence entre COPY et ADD dans un Dockerfile ?**

a) COPY est plus rapide qu'ADD  
b) ADD peut télécharger des fichiers depuis des URLs et décompresser des archives  
c) COPY ne peut copier qu'un seul fichier à la fois  
d) Il n'y a aucune différence

<details>
<summary>Réponse</summary>

**b) ADD peut télécharger des fichiers depuis des URLs et décompresser des archives**

ADD a des fonctionnalités supplémentaires :

-   Téléchargement depuis des URLs
-   Décompression automatique des archives tar
-   COPY est recommandé pour des copies simples (plus prévisible)
</details>

---

### Question 3

**Que fait cette instruction Dockerfile ?**

```dockerfile
RUN apt-get update && apt-get install -y curl && rm -rf /var/lib/apt/lists/*
```

a) Met à jour le système, installe curl et nettoie le cache  
b) Seulement met à jour le système  
c) Crée trois couches séparées  
d) Cette instruction ne fonctionne pas

<details>
<summary>Réponse</summary>

**a) Met à jour le système, installe curl et nettoie le cache**

Cette instruction combine plusieurs commandes avec `&&` pour :

1. Mettre à jour la liste des paquets
2. Installer curl
3. Nettoyer le cache APT pour réduire la taille de l'image
Le tout dans une seule couche.
 </details>

---

### Question 4

**Quelle est la meilleure pratique pour l'ordre des instructions dans un Dockerfile ?**

a) Mettre les instructions qui changent souvent en premier  
b) Mettre les instructions qui changent rarement en premier  
c) L'ordre n'a pas d'importance  
d) Toujours commencer par CMD

<details>
<summary>Réponse</summary>

**b) Mettre les instructions qui changent rarement en premier**

En mettant les instructions stables en premier (ex: installation des dépendances), on maximise la réutilisation du cache. Les instructions qui changent souvent (ex: copie du code source) doivent être à la fin.

</details>

---

### Question 5

**Que permet un multi-stage build dans un Dockerfile ?**

a) Construire plusieurs images en parallèle  
b) Séparer les étapes de build et de production pour optimiser la taille finale  
c) Créer des images pour différents environnements  
d) Accélérer uniquement le temps de construction

<details>
<summary>Réponse</summary>

**b) Séparer les étapes de build et de production pour optimiser la taille finale**

Le multi-stage build permet de :

-   Utiliser une image avec tous les outils de build dans la première étape
-   Copier seulement les artefacts nécessaires dans l'image finale
-   Réduire drastiquement la taille de l'image de production
</details>

---

### Question 6

**Quelle commande permet de voir l'historique des couches d'une image ?**

a) `docker layers image-name`  
b) `docker inspect image-name`  
c) `docker history image-name`  
d) `docker info image-name`

<details>
<summary>Réponse</summary>

**c) `docker history image-name`**

La commande `docker history` affiche toutes les couches d'une image avec :

-   La taille de chaque couche
-   La commande qui a créé la couche
-   La date de création
</details>

---

### Question 7

**Quel est l'avantage principal d'utiliser Alpine Linux comme image de base ?**

a) Plus de sécurité  
b) Plus de fonctionnalités  
c) Taille très réduite (environ 5MB)  
d) Meilleure compatibilité

<details>
<summary>Réponse</summary>

**c) Taille très réduite (environ 5MB)**

Alpine Linux est une distribution minimaliste qui :

-   Pèse seulement ~5MB vs ~200MB pour Ubuntu
-   Utilise musl libc au lieu de glibc
-   Inclut seulement les outils essentiels
-   Permet de créer des images très légères
</details>

---

### Question 8

**Comment optimiser le cache Docker lors du build ?**

a) Utiliser l'option --no-cache  
b) Ordonner les instructions des plus stables aux plus changeantes  
c) Supprimer toutes les images avant le build  
d) Utiliser seulement des images officielles

<details>
<summary>Réponse</summary>

**b) Ordonner les instructions des plus stables aux plus changeantes**

Pour optimiser le cache :

1. Instructions stables en premier (FROM, RUN apt-get update)
2. Dépendances ensuite (COPY package.json, RUN npm install)
3. Code source à la fin (COPY . .)
Ainsi, seules les couches modifiées sont reconstruites.
 </details>

---

## Questions ouvertes

### Question 9

**Expliquez la différence entre CMD et ENTRYPOINT avec des exemples.**

<details>
<summary>Réponse modèle</summary>

**CMD** : Commande par défaut, peut être remplacée

```dockerfile
CMD ["echo", "Hello World"]
# docker run mon-image → "Hello World"
# docker run mon-image echo "Bye" → "Bye"
```

**ENTRYPOINT** : Point d'entrée fixe, ne peut pas être remplacé

```dockerfile
ENTRYPOINT ["echo"]
CMD ["Hello World"]
# docker run mon-image → "Hello World"
# docker run mon-image "Bye" → "Bye"
```

**Combinaison** : ENTRYPOINT + CMD permet une commande fixe avec arguments variables.

</details>

---

### Question 10

**Décrivez les étapes pour publier une image sur Docker Hub.**

<details>
<summary>Réponse modèle</summary>

1. **Connexion** : `docker login`
2. **Tag** : `docker tag mon-image:latest username/mon-image:latest`
3. **Push** : `docker push username/mon-image:latest`
4. **Vérification** : Vérifier sur hub.docker.com
5. **Documentation** : Ajouter description et instructions

**Bonnes pratiques** :

-   Tags de version (v1.0.0, latest)
-   Description claire
-   Instructions d'utilisation
-   Tests après publication
</details>

---

### Question 11

**Donnez 3 techniques pour réduire la taille d'une image Docker.**

<details>
<summary>Réponse modèle</summary>

1. **Image de base légère** : Utiliser Alpine au lieu d'Ubuntu

    ```dockerfile
    FROM node:16-alpine  # 5MB base vs 200MB
    ```

2. **Multi-stage build** : Séparer build et production

    ```dockerfile
    FROM node:16 AS builder
    # ... build steps
    FROM node:16-alpine AS production
    COPY --from=builder /app/dist ./dist
    ```

3. **Nettoyage des caches** : Supprimer les fichiers temporaires
    ```dockerfile
    RUN apt-get update && apt-get install -y curl && \
        apt-get clean && rm -rf /var/lib/apt/lists/*
    ```

**Bonus** : .dockerignore, utilisateur non-root, élimination des outils de développement

</details>

---

### Question 12

**Expliquez le concept de "layer caching" et comment l'optimiser.**

<details>
<summary>Réponse modèle</summary>

**Layer Caching** : Docker réutilise les couches non modifiées lors des builds.

**Fonctionnement** :

-   Chaque instruction Dockerfile crée une couche
-   Docker compare l'instruction et les fichiers concernés
-   Si identiques, la couche est réutilisée (cache hit)
-   Si différents, cette couche et toutes les suivantes sont reconstruites

**Optimisation** :

```dockerfile
# ✅ Bon ordre (stable → changeant)
FROM node:16-alpine
WORKDIR /app
COPY package.json ./          # Change rarement
RUN npm install              # Cache tant que package.json identique
COPY . .                     # Change souvent, à la fin
CMD ["npm", "start"]
```

**Avantages** : Builds plus rapides, moins de bande passante, réutilisation intelligente

</details>

---

## Exercices pratiques

### Exercice 1 : Dockerfile Challenge

Créez un Dockerfile optimisé pour une application Python Flask qui :

-   Utilise une image de base légère
-   Installe les dépendances depuis requirements.txt
-   Lance l'application sur le port 5000
-   Utilise un utilisateur non-root
-   Inclut un health check

### Exercice 2 : Multi-stage Analysis

Analysez ce Dockerfile et proposez une version multi-stage optimisée :

```dockerfile
FROM node:16
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build
RUN npm install -g serve
CMD ["serve", "-s", "build", "-l", "3000"]
```

### Exercice 3 : Debug d'image

Une image fait 2GB au lieu des 100MB attendus. Listez 5 causes possibles et leurs solutions.

---

## 🏆 Validation des compétences

### Auto-évaluation

Cochez les compétences maîtrisées :

**Images Docker :**

-   [ ] Je comprends le système de couches
-   [ ] Je sais analyser une image avec `docker history`
-   [ ] Je peux optimiser la taille d'une image

**Dockerfile :**

-   [ ] Je maîtrise les instructions essentielles (FROM, RUN, COPY, CMD)
-   [ ] Je sais utiliser les multi-stage builds
-   [ ] J'applique les bonnes pratiques d'optimisation

**Registres :**

-   [ ] Je peux publier sur Docker Hub
-   [ ] Je sais configurer un registry privé
-   [ ] Je comprends la gestion des tags et versions

**Sécurité :**

-   [ ] J'utilise des utilisateurs non-root
-   [ ] Je nettoie les caches et fichiers temporaires
-   [ ] J'applique le principe du moindre privilège

### Score minimum requis : 12/16 ✅
