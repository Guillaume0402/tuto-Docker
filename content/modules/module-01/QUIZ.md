# 🎯 Quiz d'évaluation - Module 1

## Questions à choix multiples (QCM)

### Question 1

**Quelle est la principale différence entre une image Docker et un conteneur ?**

a) Une image est plus rapide qu'un conteneur  
b) Une image est un modèle en lecture seule, un conteneur est une instance en cours d'exécution  
c) Une image ne peut pas être supprimée contrairement à un conteneur  
d) Il n'y a pas de différence, ce sont des synonymes

<details>
<summary>Réponse</summary>

**b) Une image est un modèle en lecture seule, un conteneur est une instance en cours d'exécution**

Une image Docker est comme un "template" ou un "modèle" qui contient tout ce qui est nécessaire pour faire fonctionner une application. Un conteneur est créé à partir d'une image et représente l'application en cours d'exécution.

</details>

---

### Question 2

**Que fait la commande `docker run -d -p 8080:80 nginx` ?**

a) Lance Nginx en mode debug sur le port 8080  
b) Lance Nginx en arrière-plan et expose le port 80 du conteneur sur le port 8080 de l'hôte  
c) Lance Nginx en mode développement avec SSL  
d) Supprime l'image Nginx et la recrée

<details>
<summary>Réponse</summary>

**b) Lance Nginx en arrière-plan et expose le port 80 du conteneur sur le port 8080 de l'hôte**

-   `-d` : détaché (daemon), lance en arrière-plan
-   `-p 8080:80` : mapping de port (hôte:conteneur)
-   `nginx` : nom de l'image à utiliser
</details>

---

### Question 3

**Quel est l'avantage principal des conteneurs par rapport aux machines virtuelles ?**

a) Ils sont plus sécurisés  
b) Ils prennent moins de place et démarrent plus vite  
c) Ils peuvent seulement fonctionner sur Linux  
d) Ils ne nécessitent pas de réseau

<details>
<summary>Réponse</summary>

**b) Ils prennent moins de place et démarrent plus vite**

Les conteneurs partagent le noyau de l'OS hôte, contrairement aux VMs qui embarquent un OS complet. Cela réduit considérablement la taille (MB vs GB) et le temps de démarrage (secondes vs minutes).

</details>

---

### Question 4

**Où sont stockées par défaut les images Docker officielles ?**

a) GitHub  
b) GitLab  
c) Docker Hub  
d) Sur votre disque dur local uniquement

<details>
<summary>Réponse</summary>

**c) Docker Hub**

Docker Hub est le registre public officiel de Docker où sont hébergées les images officielles et communautaires.

</details>

---

### Question 5

**Que se passe-t-il quand vous exécutez `docker run hello-world` pour la première fois ?**

a) Une erreur car l'image n'existe pas  
b) Docker télécharge l'image depuis Docker Hub, crée un conteneur et l'exécute  
c) Docker crée une image vide  
d) Rien, il faut d'abord installer l'image manuellement

<details>
<summary>Réponse</summary>

**b) Docker télécharge l'image depuis Docker Hub, crée un conteneur et l'exécute**

Si l'image n'est pas présente localement, Docker la télécharge automatiquement depuis le registre par défaut (Docker Hub), puis crée et lance le conteneur.

</details>

---

## Questions ouvertes

### Question 6

**Expliquez en 2-3 phrases pourquoi Docker résout le problème "ça marche sur ma machine".**

<details>
<summary>Réponse suggérée</summary>

Docker encapsule l'application avec toutes ses dépendances, sa configuration et son environnement d'exécution dans un conteneur portable. Ce conteneur fonctionnera de manière identique sur n'importe quel système supportant Docker, éliminant ainsi les différences d'environnement entre le développement, les tests et la production.

</details>

---

### Question 7

**Citez 3 avantages des conteneurs par rapport aux machines virtuelles.**

<details>
<summary>Réponse suggérée</summary>

1. **Performance** : Démarrage plus rapide (secondes vs minutes) et overhead minimal
2. **Efficacité** : Utilisation des ressources optimisée, plusieurs conteneurs partagent le même OS
3. **Portabilité** : Plus légers à distribuer et déployer (MB vs GB)
 </details>

---

### Question 8

**Quelle est la différence entre `docker ps` et `docker ps -a` ?**

<details>
<summary>Réponse suggérée</summary>

-   `docker ps` affiche uniquement les conteneurs en cours d'exécution (statut "Up")
-   `docker ps -a` affiche tous les conteneurs (en cours, arrêtés, en pause, etc.)
</details>

---

## Exercices pratiques

### Exercice 1 : Commandes de base

**Écrivez la séquence de commandes pour :**

1. Lancer un serveur web Apache en arrière-plan sur le port 8090
2. Vérifier qu'il fonctionne
3. Voir ses logs
4. L'arrêter proprement
5. Le supprimer

<details>
<summary>Solution</summary>

```bash
# 1. Lancer Apache
docker run -d -p 8090:80 --name mon-apache httpd

# 2. Vérifier
curl http://localhost:8090
# ou docker ps

# 3. Voir les logs
docker logs mon-apache

# 4. Arrêter
docker stop mon-apache

# 5. Supprimer
docker rm mon-apache
```

</details>

---

### Exercice 2 : Mode interactif

**Que va afficher cette séquence de commandes ?**

```bash
docker run -it --name test ubuntu bash
echo "Hello Docker" > /tmp/message.txt
exit
docker start test
docker exec -it test cat /tmp/message.txt
```

<details>
<summary>Réponse</summary>

La séquence va afficher : `Hello Docker`

Explication : Le fichier créé dans le conteneur persiste tant que le conteneur n'est pas supprimé. Quand on redémarre le conteneur avec `docker start` et qu'on exécute une commande avec `docker exec`, le fichier est toujours là.

</details>

---

## Projet d'évaluation

### Mise en situation

Vous êtes développeur dans une startup et vous devez préparer une démonstration pour vos investisseurs. Vous devez containeriser une application web simple.

### Objectifs

1. Créer une page web qui affiche des informations sur votre "startup"
2. La containeriser avec Docker
3. La rendre accessible via un navigateur
4. Documenter le processus

### Livrables attendus

1. **Code HTML/CSS** de votre page web
2. **Commandes Docker** utilisées
3. **Documentation** expliquant comment lancer votre application
4. **Screenshot** de l'application fonctionnant dans le navigateur

### Critères d'évaluation

-   ✅ Page web créative et fonctionnelle (25%)
-   ✅ Utilisation correcte de Docker (25%)
-   ✅ Documentation claire (25%)
-   ✅ Fonctionnement de bout en bout (25%)

### Bonus (points supplémentaires)

-   Utilisation de volumes pour le développement
-   Ajout de JavaScript interactif
-   Design responsive
-   Plusieurs pages liées

---

## Barème de notation

### QCM (40 points)

-   Question 1-5 : 8 points chacune
-   Chaque bonne réponse = points complets
-   Chaque mauvaise réponse = 0 point

### Questions ouvertes (30 points)

-   Question 6-8 : 10 points chacune
-   Notation sur la précision et la compréhension

### Projet pratique (30 points)

-   Répartition selon les critères ci-dessus

### Notes finales

-   **90-100 points** : Excellente maîtrise ⭐⭐⭐
-   **75-89 points** : Bonne compréhension ⭐⭐
-   **60-74 points** : Compréhension satisfaisante ⭐
-   **< 60 points** : Révision nécessaire 🔄

---

## 📚 Ressources pour réviser

### Points clés à retenir

-   Différence image/conteneur
-   Commandes de base : `run`, `ps`, `stop`, `rm`
-   Options importantes : `-d`, `-p`, `-it`, `--name`
-   Concept de portabilité
-   Docker Hub et registres

### Commandes essentielles à maîtriser

```bash
docker run <image>
docker ps / docker ps -a
docker stop <container>
docker rm <container>
docker images
docker logs <container>
docker exec -it <container> <command>
```

### Documentation

-   [Docker Official Docs](https://docs.docker.com/)
-   [Docker Run Reference](https://docs.docker.com/engine/reference/run/)
-   [Docker Hub](https://hub.docker.com/)

**🎯 Bonne chance pour votre évaluation !**
