# 📖 Ressources complémentaires - Module 1

## 📚 Documentation officielle

### Docker

-   **[Docker Documentation](https://docs.docker.com/)** - Documentation officielle complète
-   **[Docker Run Reference](https://docs.docker.com/engine/reference/run/)** - Référence complète de la commande `docker run`
-   **[Docker CLI Reference](https://docs.docker.com/engine/reference/commandline/cli/)** - Toutes les commandes Docker
-   **[Docker Get Started](https://docs.docker.com/get-started/)** - Guide officiel pour débutants

### Installation

-   **[Docker Desktop](https://www.docker.com/products/docker-desktop)** - Installation pour Windows et macOS
-   **[Docker Engine on Linux](https://docs.docker.com/engine/install/)** - Installation sur différentes distributions Linux
-   **[Post-installation steps](https://docs.docker.com/engine/install/linux-postinstall/)** - Configuration après installation Linux

---

## 🎥 Vidéos tutoriels

### Français

-   **[Grafikart - Docker](https://www.youtube.com/watch?v=IRd4vHBuhN0)** - Introduction complète en français
-   **[Cocadmin - Docker pour débutants](https://www.youtube.com/watch?v=XgKOC6X8W8k)** - Concepts de base
-   **[FormationVidéo - Docker](https://www.youtube.com/playlist?list=PLrAHaD8xfLZW0xyltEhF7PnKO5BWMY8T8)** - Série complète

### Anglais

-   **[Docker Official YouTube](https://www.youtube.com/c/DockerIo)** - Chaîne officielle Docker
-   **[freeCodeCamp - Docker Course](https://www.youtube.com/watch?v=9zUHg7xjIqQ)** - Cours complet gratuit
-   **[TechWorld with Nana](https://www.youtube.com/watch?v=3c-iBn73dDE)** - Docker Tutorial for Beginners

---

## 🛠️ Outils et ressources pratiques

### Environnements d'apprentissage

-   **[Play with Docker](https://labs.play-with-docker.com/)** - Environnement Docker gratuit dans le navigateur
-   **[Katacoda Docker](https://www.katacoda.com/courses/docker)** - Tutoriels interactifs
-   **[Docker Training](https://training.docker.com/)** - Formation officielle Docker

### Cheat Sheets

-   **[Docker Cheat Sheet](https://github.com/wsargent/docker-cheat-sheet)** - Antisèche complète
-   **[Dockerlabs Cheat Sheet](https://dockerlabs.collabnix.com/docker/cheatsheet/)** - Commandes essentielles
-   **[Docker Quick Reference](https://github.com/JensPiegsa/docker-cheat-sheet)** - Référence rapide

### Outils visuels

-   **[Docker Desktop](https://www.docker.com/products/docker-desktop)** - Interface graphique officielle
-   **[Portainer](https://www.portainer.io/)** - Interface web pour gérer Docker
-   **[Lazydocker](https://github.com/jesseduffield/lazydocker)** - Interface en ligne de commande améliorée

---

## 📖 Livres recommandés

### Débutants

-   **"Docker : Pratique des architectures à base de conteneurs"** - Sébastien Goasguen
-   **"Docker in Action"** - Jeff Nickoloff
-   **"Learn Docker in a Month of Lunches"** - Elton Stoneman

### Avancés

-   **"Docker Deep Dive"** - Nigel Poulton
-   **"Docker: Up & Running"** - Karl Matthias & Sean Kane
-   **"The Docker Book"** - James Turnbull

---

## 🌐 Sites web et blogs

### Blogs techniques

-   **[Docker Blog](https://www.docker.com/blog/)** - Blog officiel Docker
-   **[Container Journal](https://containerjournal.com/)** - Actualités sur les conteneurs
-   **[The New Stack](https://thenewstack.io/category/containers/)** - Articles sur les conteneurs

### Communautés

-   **[Docker Community](https://www.docker.com/community)** - Communauté officielle
-   **[r/docker](https://www.reddit.com/r/docker/)** - Subreddit Docker
-   **[Stack Overflow - Docker](https://stackoverflow.com/questions/tagged/docker)** - Questions/réponses

---

## 🎯 Exercices supplémentaires

### Sites d'entraînement

-   **[Docker Challenges](https://dockerlabs.collabnix.com/)**
-   **[Kodekloud Docker Labs](https://kodekloud.com/courses/docker-for-the-absolute-beginner/)**
-   **[A Cloud Guru - Docker](https://acloudguru.com/course/docker-fundamentals)**

### Projets pratiques

1. **Containeriser une application Node.js**
2. **Créer un serveur web avec volumes persistants**
3. **Déployer WordPress avec Docker**
4. **Créer une API REST containerisée**

---

## 🔍 Glossaire

### Termes essentiels

**Container (Conteneur)**
: Instance en cours d'exécution d'une image Docker

**Image**
: Modèle en lecture seule utilisé pour créer des conteneurs

**Dockerfile**
: Fichier texte contenant les instructions pour construire une image

**Registry (Registre)**
: Service de stockage et distribution d'images Docker

**Docker Hub**
: Registre public officiel de Docker

**Docker Engine**
: Runtime qui gère les conteneurs Docker

**Layer (Couche)**
: Chaque instruction dans un Dockerfile crée une couche dans l'image

**Volume**
: Mécanisme pour persister les données en dehors du conteneur

**Port Mapping**
: Redirection des ports du conteneur vers l'hôte

**Daemon**
: Service Docker qui s'exécute en arrière-plan

---

## 🆘 FAQ - Questions fréquentes

### Installation et configuration

**Q : Docker Desktop ne démarre pas sur Windows**
R : Vérifiez que :

-   La virtualisation est activée dans le BIOS
-   WSL2 est installé et configuré
-   Hyper-V est activé (Windows Pro/Enterprise)

**Q : "Permission denied" sur Linux**
R : Ajoutez votre utilisateur au groupe docker :

```bash
sudo usermod -aG docker $USER
newgrp docker
```

**Q : Les images sont lentes à télécharger**
R : Configurez un mirror Docker plus proche :

```bash
# Créer /etc/docker/daemon.json
{
  "registry-mirrors": ["https://registry.docker-cn.com"]
}
```

### Utilisation

**Q : Différence entre `docker run` et `docker start` ?**
R :

-   `docker run` : Crée ET démarre un nouveau conteneur
-   `docker start` : Démarre un conteneur existant

**Q : Comment accéder aux fichiers dans un conteneur ?**
R : Utilisez `docker exec` ou montez un volume :

```bash
docker exec -it <container> bash
# ou
docker run -v $(pwd):/app <image>
```

**Q : Mon conteneur s'arrête immédiatement**
R : Le processus principal se termine. Utilisez `-it` pour les conteneurs interactifs ou vérifiez que votre application ne se ferme pas.

---

## 🎯 Checklist de révision

Avant de passer au module suivant, vérifiez que vous maîtrisez :

### Concepts théoriques

-   [ ] Définition de Docker et de la conteneurisation
-   [ ] Différence entre conteneurs et machines virtuelles
-   [ ] Concepts d'images, conteneurs, et registres
-   [ ] Architecture Docker (daemon, CLI, API)
-   [ ] Avantages et cas d'usage de Docker

### Compétences pratiques

-   [ ] Installation de Docker sur votre OS
-   [ ] Exécution de `docker run` avec différentes options
-   [ ] Gestion des conteneurs (`start`, `stop`, `rm`)
-   [ ] Utilisation du mode interactif (`-it`)
-   [ ] Mapping de ports (`-p`)
-   [ ] Consultation des logs (`docker logs`)
-   [ ] Nettoyage de l'environnement Docker

### Commandes maîtrisées

```bash
docker run [options] <image> [command]
docker ps [-a]
docker start/stop/restart <container>
docker rm <container>
docker images
docker rmi <image>
docker logs <container>
docker exec -it <container> <command>
docker system prune
```

---

## ➡️ Préparation pour le Module 2

### Prérequis pour le module suivant

-   Docker installé et fonctionnel
-   Compréhension des concepts de base
-   Maîtrise des commandes essentielles

### Aperçu du Module 2

Le Module 2 approfondira :

-   **Commandes Docker avancées**
-   **Gestion détaillée des images**
-   **Options de `docker run`**
-   **Premiers Dockerfiles**
-   **Bonnes pratiques**

### Préparation recommandée

1. Pratiquez les exercices du TP
2. Explorez Docker Hub pour découvrir différentes images
3. Essayez de containeriser une application simple
4. Lisez la documentation des commandes Docker

**🚀 Vous êtes maintenant prêt pour approfondir Docker avec le Module 2 !**
