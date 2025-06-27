# Quiz Module 4 : Images Docker - Création et Gestion

## Question 1 : Concepts de base

**Qu'est-ce qu'une image Docker ?**

A) Un conteneur en cours d'exécution  
B) Un modèle en lecture seule pour créer des conteneurs  
C) Un fichier de configuration Docker  
D) Un réseau virtuel Docker

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

Une image Docker est un modèle (template) en lecture seule qui contient tout le nécessaire pour exécuter une application : le code, les bibliothèques, les dépendances, et les configurations.

</details>

---

## Question 2 : Dockerfile - Instruction FROM

**Quelle est la bonne pratique pour choisir une image de base ?**

A) Toujours utiliser `ubuntu:latest`  
B) Utiliser l'image la plus récente disponible  
C) Choisir l'image la plus légère possible (ex: Alpine)  
D) Utiliser uniquement des images officielles

<details>
<summary>Voir la réponse</summary>

**Réponse : C**

Il faut choisir l'image la plus légère possible qui répond aux besoins. Les images Alpine sont souvent préférées car elles sont très petites (quelques MB vs plusieurs centaines de MB).

</details>

---

## Question 3 : Optimisation des couches

**Dans quel ordre devez-vous placer ces instructions pour optimiser le cache Docker ?**

```dockerfile
1. COPY . .
2. COPY package.json ./
3. RUN npm install
4. FROM node:alpine
```

A) 4, 1, 2, 3  
B) 4, 2, 3, 1  
C) 1, 2, 3, 4  
D) 4, 1, 3, 2

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

L'ordre correct est : FROM (4), COPY package.json (2), RUN npm install (3), COPY . . (1).
Cela permet d'utiliser le cache pour l'installation des dépendances même si le code source change.

</details>

---

## Question 4 : Multi-stage builds

**Quel est l'avantage principal des multi-stage builds ?**

A) Accélérer la construction de l'image  
B) Réduire la taille de l'image finale  
C) Améliorer la sécurité  
D) Faciliter le debugging

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

Les multi-stage builds permettent de séparer l'environnement de construction de l'environnement de production, gardant seulement les artefacts nécessaires dans l'image finale.

</details>

---

## Question 5 : Instructions Dockerfile

**Quelle est la différence entre CMD et ENTRYPOINT ?**

A) CMD est obligatoire, ENTRYPOINT est optionnel  
B) ENTRYPOINT peut être surchargé, CMD non  
C) CMD peut être surchargé facilement, ENTRYPOINT définit le point d'entrée fixe  
D) Il n'y a aucune différence

<details>
<summary>Voir la réponse</summary>

**Réponse : C**

CMD peut être facilement surchargé lors du `docker run`, tandis qu'ENTRYPOINT définit un point d'entrée fixe. Les arguments de CMD deviennent les paramètres d'ENTRYPOINT.

</details>

---

## Question 6 : Fichier .dockerignore

**À quoi sert le fichier .dockerignore ?**

A) À ignorer les erreurs de construction  
B) À exclure des fichiers du contexte de construction  
C) À désactiver le cache Docker  
D) À masquer les mots de passe

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

Le fichier .dockerignore fonctionne comme .gitignore : il exclut des fichiers et dossiers du contexte envoyé au daemon Docker, réduisant la taille du contexte et améliorant les performances.

</details>

---

## Question 7 : Optimisation de taille

**Laquelle de ces pratiques NE réduit PAS la taille d'une image ?**

A) Utiliser une image de base Alpine  
B) Nettoyer le cache après installation de paquets  
C) Utiliser plusieurs instructions RUN séparées  
D) Supprimer les fichiers temporaires

<details>
<summary>Voir la réponse</summary>

**Réponse : C**

Utiliser plusieurs instructions RUN crée plusieurs couches. Il vaut mieux les regrouper avec `&&` pour créer une seule couche et permettre le nettoyage dans la même instruction.

</details>

---

## Question 8 : Variables d'environnement

**Comment définir une variable d'environnement dans un Dockerfile ?**

A) `VAR NODE_ENV=production`  
B) `ENV NODE_ENV=production`  
C) `SET NODE_ENV=production`  
D) `EXPORT NODE_ENV=production`

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

L'instruction ENV permet de définir des variables d'environnement qui seront disponibles dans le conteneur.

</details>

---

## Question 9 : Ports et exposition

**Que fait l'instruction EXPOSE dans un Dockerfile ?**

A) Elle ouvre automatiquement le port sur l'hôte  
B) Elle documente les ports utilisés par l'application  
C) Elle bloque tous les autres ports  
D) Elle configure le pare-feu du conteneur

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

EXPOSE est purement documentaire. Elle indique les ports que l'application utilise, mais ne les publie pas automatiquement. Il faut utiliser `-p` lors du `docker run`.

</details>

---

## Question 10 : Bonnes pratiques de sécurité

**Quelle est la meilleure pratique de sécurité lors de la création d'images ?**

A) Utiliser toujours l'utilisateur root  
B) Créer et utiliser un utilisateur non-privilégié  
C) Désactiver tous les ports  
D) Chiffrer l'image

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

Il faut créer un utilisateur non-privilégié avec `RUN adduser` et utiliser `USER` pour basculer dessus. Cela limite les risques si le conteneur est compromis.

</details>

---

## Question 11 : Cache Docker

**Comment forcer la reconstruction complète d'une image sans utiliser le cache ?**

A) `docker build --no-cache -t myapp .`  
B) `docker build --force -t myapp .`  
C) `docker build --refresh -t myapp .`  
D) `docker build --clean -t myapp .`

<details>
<summary>Voir la réponse</summary>

**Réponse : A**

L'option `--no-cache` force Docker à ignorer le cache et à reconstruire toutes les couches depuis le début.

</details>

---

## Question 12 : Tags et versions

**Quelle est la meilleure pratique pour tagger des images ?**

A) Utiliser uniquement `latest`  
B) Utiliser des versions sémantiques (1.0.0, 1.1.0)  
C) Utiliser des dates (2024-01-15)  
D) Utiliser des hash Git

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

Les versions sémantiques sont claires et permettent une gestion prévisible des mises à jour. On peut combiner avec d'autres stratégies selon les besoins.

</details>

---

## Question 13 : Instructions COPY vs ADD

**Quand utiliser ADD plutôt que COPY ?**

A) ADD est plus moderne que COPY  
B) Pour copier des fichiers locaux  
C) Pour télécharger et extraire des archives  
D) ADD est plus rapide que COPY

<details>
<summary>Voir la réponse</summary>

**Réponse : C**

ADD a des fonctionnalités supplémentaires (extraction d'archives, téléchargement d'URLs) mais COPY est préféré pour la copie simple de fichiers locaux car plus explicite.

</details>

---

## Question 14 : Répertoire de travail

**À quoi sert l'instruction WORKDIR ?**

A) À créer un nouveau dossier  
B) À définir le répertoire de travail pour les instructions suivantes  
C) À supprimer un dossier  
D) À lister le contenu d'un dossier

<details>
<summary>Voir la réponse</summary>

**Réponse : B**

WORKDIR définit le répertoire de travail pour toutes les instructions suivantes (RUN, CMD, ENTRYPOINT, COPY, ADD). Il crée le dossier s'il n'existe pas.

</details>

---

## Question 15 : Debugging d'images

**Comment inspecter le contenu d'une image Docker ?**

A) `docker inspect myimage`  
B) `docker run --rm -it myimage sh`  
C) `docker history myimage`  
D) Toutes les réponses ci-dessus

<details>
<summary>Voir la réponse</summary>

**Réponse : D**

-   `docker inspect` : métadonnées et configuration
-   `docker run -it sh` : explorer le système de fichiers
-   `docker history` : voir les couches et leur taille
</details>

---

## 🎯 Score et évaluation

-   **13-15 bonnes réponses** : Excellent ! Vous maîtrisez parfaitement la création d'images Docker
-   **10-12 bonnes réponses** : Très bien ! Quelques points à revoir mais vous avez une bonne compréhension
-   **7-9 bonnes réponses** : Correct. Relisez le cours et refaites le TP pour consolider
-   **Moins de 7** : Reprenez le module depuis le début et refaites les exercices pratiques

## 📚 Points clés à retenir

1. **Images = Templates en lecture seule** pour créer des conteneurs
2. **Optimisation des couches** : ordre des instructions important pour le cache
3. **Multi-stage builds** : séparer construction et production
4. **Sécurité** : utilisateurs non-privilégiés, scan des vulnérabilités
5. **Bonnes pratiques** : images légères, documentation, versioning

---

_Félicitations ! Vous êtes maintenant capable de créer, optimiser et publier des images Docker professionnelles. Passez au module 5 pour apprendre les réseaux Docker !_
