# 🐳 Module 1 : Introduction et concepts fondamentaux

**Durée estimée :** 4 heures  
**Niveau :** Débutant  
**Prérequis :** Connaissances de base en ligne de commande

## 🎯 Objectifs pédagogiques

À la fin de ce module, vous serez capable de :

-   ✅ **Expliquer** ce qu'est Docker et pourquoi l'utiliser
-   ✅ **Différencier** conteneurs et machines virtuelles
-   ✅ **Identifier** les composants de l'écosystème Docker
-   ✅ **Installer** Docker sur votre système
-   ✅ **Exécuter** votre premier conteneur Docker

## 📚 Plan du module

### 1. Qu'est-ce que Docker ? (45 min)

### 2. Conteneurs vs Machines Virtuelles (30 min)

### 3. Concepts fondamentaux (60 min)

### 4. Installation de Docker (45 min)

### 5. Premier conteneur Hello World (30 min)

### 6. Exercices pratiques (30 min)

---

## 1. 🤔 Qu'est-ce que Docker ?

### Définition

**Docker** est une plateforme de conteneurisation qui permet d'empaqueter, distribuer et exécuter des applications dans des environnements isolés appelés **conteneurs**.

### Problèmes résolus par Docker

#### 🚫 Le problème "Ça marche sur ma machine"

Avant Docker :

```
Développeur A: "Mon code fonctionne parfaitement !"
Développeur B: "Étrange, ça plante chez moi..."
Ops: "Et en production, c'est encore différent !"
```

#### ✅ La solution Docker

Avec Docker :

```
Tout le monde: "Ça marche partout de la même façon !"
```

### Les avantages de Docker

| Avantage        | Description                         | Exemple                     |
| --------------- | ----------------------------------- | --------------------------- |
| **Portabilité** | Fonctionne partout de la même façon | Dev → Test → Prod           |
| **Isolation**   | Applications séparées               | WordPress + Redis + Node.js |
| **Efficacité**  | Partage des ressources              | Démarrage en secondes       |
| **Scalabilité** | Montée en charge facile             | 1 → 100 instances           |
| **Versioning**  | Gestion des versions                | v1.0, v1.1, v2.0            |

### Cas d'usage concrets

#### 🌐 Développement web

```bash
# Une stack complète en quelques secondes
docker run -d nginx
docker run -d mysql
docker run -d redis
```

#### 🚀 Microservices

```bash
# Chaque service dans son conteneur
auth-service/
payment-service/
notification-service/
```

#### 🔄 CI/CD

```bash
# Tests dans un environnement propre
docker run --rm myapp npm test
```

---

## 2. ⚖️ Conteneurs vs Machines Virtuelles

### Architecture comparée

#### Machines Virtuelles (VMs)

```
┌─────────────────────────────────────┐
│           Application A             │
├─────────────────────────────────────┤
│          OS Guest (Linux)           │
├─────────────────────────────────────┤
│            Hypervisor               │
├─────────────────────────────────────┤
│          OS Host (Windows)          │
├─────────────────────────────────────┤
│             Hardware                │
└─────────────────────────────────────┘
```

#### Conteneurs Docker

```
┌─────────────────────────────────────┐
│           Application A             │
├─────────────────────────────────────┤
│           Docker Engine             │
├─────────────────────────────────────┤
│          OS Host (Linux)            │
├─────────────────────────────────────┤
│             Hardware                │
└─────────────────────────────────────┘
```

### Comparaison détaillée

| Critère         | Machines Virtuelles | Conteneurs Docker         |
| --------------- | ------------------- | ------------------------- |
| **Taille**      | 2-20 GB             | 50-500 MB                 |
| **Démarrage**   | 1-5 minutes         | 1-5 secondes              |
| **Isolation**   | Complète (OS)       | Processus                 |
| **Performance** | Overhead important  | Presque native            |
| **Sécurité**    | Très élevée         | Élevée                    |
| **Cas d'usage** | Applications legacy | Applications cloud-native |

### Analogie : Conteneurs maritimes

🚢 **Bateau = Serveur**  
📦 **Conteneur = Application**

Avant les conteneurs :

-   Chargement en vrac
-   Incompatibilités
-   Lenteur

Après les conteneurs :

-   Standardisation
-   Interchangeabilité
-   Efficacité

---

## 3. 🧱 Concepts fondamentaux

### L'écosystème Docker

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   Images    │───▶│ Conteneurs  │───▶│  Registres  │
│             │    │             │    │             │
│ Modèles     │    │ Instances   │    │ Docker Hub  │
│ read-only   │    │ en cours    │    │ Stockage    │
└─────────────┘    └─────────────┘    └─────────────┘
```

### 🏗️ Images Docker

#### Qu'est-ce qu'une image ?

Une **image Docker** est un modèle en lecture seule qui contient :

-   Le système de fichiers
-   Les dépendances
-   La configuration
-   Les métadonnées

#### Structure en couches (layers)

```
┌─────────────────────┐ ← Votre application
├─────────────────────┤ ← Dépendances (npm, pip...)
├─────────────────────┤ ← Runtime (Node.js, Python...)
├─────────────────────┤ ← OS de base (Ubuntu, Alpine...)
└─────────────────────┘ ← Bootfs (kernel)
```

**Avantage :** Partage des couches communes → Économie d'espace

### 📦 Conteneurs Docker

#### Qu'est-ce qu'un conteneur ?

Un **conteneur** est une instance en cours d'exécution d'une image :

-   Processus isolé
-   Système de fichiers temporaire
-   Réseau virtuel
-   Ressources limitées

#### Cycle de vie d'un conteneur

```
Créé → En cours → Arrêté → Supprimé
  ↑        ↓         ↑       ↓
Restart ←────── Pause ────────→
```

### 🏪 Docker Hub et Registres

#### Docker Hub

-   Registre public officiel
-   Milliers d'images prêtes
-   Images officielles certifiées

#### Images populaires

```bash
nginx          # Serveur web
mysql          # Base de données
node           # Runtime JavaScript
python         # Runtime Python
redis          # Cache en mémoire
ubuntu         # OS Ubuntu
```

### 🐳 Docker Engine

Le moteur Docker comprend :

1. **Docker Daemon** (`dockerd`)

    - Service qui tourne en arrière-plan
    - Gère images, conteneurs, réseaux

2. **Docker CLI** (`docker`)

    - Interface en ligne de commande
    - Communique avec le daemon

3. **Docker API**
    - Interface REST
    - Utilisée par les outils tiers

---

## 4. 💻 Installation de Docker

### Installation sur Windows

#### Prérequis

-   Windows 10/11 Pro, Enterprise ou Education
-   Virtualisation activée dans le BIOS
-   WSL2 installé

#### Étapes d'installation

1. **Télécharger Docker Desktop**

    ```
    https://docker.com/products/docker-desktop
    ```

2. **Exécuter l'installateur**

    - Double-clic sur `Docker Desktop Installer.exe`
    - Suivre les instructions

3. **Redémarrer l'ordinateur**

4. **Vérifier l'installation**
    ```powershell
    docker --version
    docker run hello-world
    ```

### Installation sur macOS

#### Avec Docker Desktop

```bash
# Télécharger depuis le site officiel
# Ou avec Homebrew
brew install --cask docker
```

#### Vérification

```bash
docker --version
docker info
```

### Installation sur Linux (Ubuntu)

#### Méthode recommandée

```bash
# Mise à jour du système
sudo apt update

# Installation des prérequis
sudo apt install apt-transport-https ca-certificates curl gnupg lsb-release

# Ajout de la clé GPG Docker
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Ajout du dépôt Docker
echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Installation de Docker
sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io

# Ajout de l'utilisateur au groupe docker
sudo usermod -aG docker $USER

# Redémarrage de session ou
newgrp docker
```

#### Vérification

```bash
docker --version
sudo systemctl status docker
```

---

## 5. 👋 Premier conteneur Hello World

### La commande magique

```bash
docker run hello-world
```

### Que se passe-t-il ?

1. **Recherche locale** : Docker cherche l'image `hello-world` localement
2. **Téléchargement** : Si non trouvée, téléchargement depuis Docker Hub
3. **Création** : Création d'un nouveau conteneur
4. **Exécution** : Démarrage du conteneur
5. **Affichage** : Le programme affiche un message
6. **Arrêt** : Le conteneur s'arrête automatiquement

### Sortie attendue

```
Hello from Docker!
This message shows that your installation appears to be working correctly.

To generate this message, Docker took the following steps:
 1. The Docker client contacted the Docker daemon.
 2. The Docker daemon pulled the "hello-world" image from the Docker Hub.
 3. The Docker daemon created a new container from that image which runs the
    executable that produces the output you are currently reading.
 4. The Docker daemon streamed that output to the Docker client, which sent it
    to your terminal.
```

### Commandes de base pour débuter

#### Lister les images

```bash
docker images
# ou
docker image ls
```

#### Lister les conteneurs

```bash
# Conteneurs en cours
docker ps

# Tous les conteneurs
docker ps -a
```

#### Nettoyer

```bash
# Supprimer un conteneur
docker rm <container_id>

# Supprimer une image
docker rmi <image_name>
```

---

## 6. 🛠️ Exercices pratiques

### Exercice 1 : Exploration de base

**Objectif :** Se familiariser avec les commandes de base

```bash
# 1. Vérifier la version de Docker
docker --version

# 2. Afficher les informations système
docker info

# 3. Lancer hello-world
docker run hello-world

# 4. Lister les images téléchargées
docker images

# 5. Lister tous les conteneurs
docker ps -a
```

**Questions :**

-   Quelle est la taille de l'image hello-world ?
-   Combien de conteneurs avez-vous créés ?

### Exercice 2 : Premier serveur web

**Objectif :** Lancer un serveur web Nginx

```bash
# 1. Lancer Nginx en arrière-plan
docker run -d -p 8080:80 --name mon-nginx nginx

# 2. Vérifier que le conteneur fonctionne
docker ps

# 3. Tester dans le navigateur
# Aller sur http://localhost:8080

# 4. Voir les logs
docker logs mon-nginx

# 5. Arrêter le conteneur
docker stop mon-nginx

# 6. Supprimer le conteneur
docker rm mon-nginx
```

**Questions :**

-   Que signifie `-d` ?
-   Que fait `-p 8080:80` ?
-   Pourquoi utiliser `--name` ?

### Exercice 3 : Mode interactif

**Objectif :** Utiliser un conteneur en mode interactif

```bash
# 1. Lancer Ubuntu en mode interactif
docker run -it ubuntu bash

# 2. Explorer le système
ls /
cat /etc/os-release
whoami

# 3. Installer quelque chose
apt update
apt install curl -y
curl --version

# 4. Sortir du conteneur
exit

# 5. Relancer le même conteneur
docker run -it ubuntu bash

# 6. Vérifier si curl est toujours là
curl --version
```

**Questions :**

-   Pourquoi curl n'est plus installé ?
-   Comment persister les modifications ?

### Exercice 4 : Nettoyage

**Objectif :** Apprendre à nettoyer son environnement Docker

```bash
# 1. Lister tous les conteneurs
docker ps -a

# 2. Supprimer tous les conteneurs arrêtés
docker container prune

# 3. Lister toutes les images
docker images

# 4. Supprimer les images non utilisées
docker image prune

# 5. Nettoyage complet (attention !)
docker system prune
```

## 📝 Points clés à retenir

### Les concepts essentiels

1. **Docker ≠ VM** : Plus léger, plus rapide
2. **Image = Modèle**, **Conteneur = Instance**
3. **Isolation** sans overhead important
4. **Portabilité** entre environnements

### Commandes de base

```bash
docker run <image>     # Créer et démarrer un conteneur
docker ps              # Lister les conteneurs actifs
docker ps -a           # Lister tous les conteneurs
docker images          # Lister les images
docker stop <name>     # Arrêter un conteneur
docker rm <name>       # Supprimer un conteneur
docker rmi <image>     # Supprimer une image
```

### Bonnes pratiques

-   ✅ Toujours donner un nom aux conteneurs avec `--name`
-   ✅ Utiliser `-d` pour les services en arrière-plan
-   ✅ Nettoyer régulièrement avec `docker system prune`
-   ✅ Lire la documentation des images sur Docker Hub

## 🎯 Quiz d'évaluation

### Questions à choix multiples

**1. Quelle est la principale différence entre une image et un conteneur ?**

-   a) Une image est plus rapide qu'un conteneur
-   b) Une image est un modèle, un conteneur est une instance
-   c) Une image ne peut pas être supprimée
-   d) Il n'y a pas de différence

**2. Que fait la commande `docker run -d nginx` ?**

-   a) Lance Nginx en mode debug
-   b) Lance Nginx en arrière-plan
-   c) Lance Nginx en mode développement
-   d) Supprime l'image Nginx

**3. Où sont stockées les images Docker officielles ?**

-   a) GitHub
-   b) GitLab
-   c) Docker Hub
-   d) Docker Store

### Questions ouvertes

**4. Expliquez en quelques mots pourquoi Docker résout le problème "ça marche sur ma machine".**

**5. Citez 3 avantages des conteneurs par rapport aux machines virtuelles.**

## 🔗 Ressources supplémentaires

### Documentation officielle

-   [Docker Documentation](https://docs.docker.com/)
-   [Docker Hub](https://hub.docker.com/)
-   [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Tutoriels interactifs

-   [Play with Docker](https://labs.play-with-docker.com/)
-   [Docker Curriculum](https://docker-curriculum.com/)

### Cheat sheets

-   [Docker Cheat Sheet](https://dockerlabs.collabnix.com/docker/cheatsheet/)

---

## ➡️ Prochaine étape

Félicitations ! Vous avez terminé le Module 1.

**Module 2 : Installation et premiers pas** vous attend pour approfondir :

-   Configuration avancée de Docker
-   Commandes essentielles détaillées
-   Gestion des images et conteneurs
-   Premiers Dockerfiles

🚀 **Continuez votre apprentissage !**
