# 🛠️ Travaux Pratiques - Module 1

## TP1 : Installation et vérification

### Objectif

Installer Docker sur votre système et vérifier que tout fonctionne correctement.

### Instructions

1. **Installation**

    - Suivez les instructions d'installation selon votre OS
    - Redémarrez si nécessaire

2. **Tests de base**

    ```bash
    # Vérifier la version
    docker --version

    # Informations système
    docker info

    # Premier conteneur
    docker run hello-world
    ```

3. **Validation**
    - Capture d'écran de la sortie `docker --version`
    - Capture d'écran du message hello-world

### Livrables

-   Screenshot de l'installation réussie
-   Réponses aux questions du README

---

## TP2 : Exploration des conteneurs

### Objectif

Comprendre le cycle de vie des conteneurs et les commandes de base.

### Scenario

Vous êtes développeur web et vous voulez tester différents serveurs web.

### Instructions

1. **Nginx**

    ```bash
    # Lancer Nginx
    docker run -d -p 8080:80 --name serveur-nginx nginx

    # Tester
    curl http://localhost:8080

    # Voir les logs
    docker logs serveur-nginx
    ```

2. **Apache**

    ```bash
    # Lancer Apache
    docker run -d -p 8081:80 --name serveur-apache httpd

    # Tester
    curl http://localhost:8081
    ```

3. **Comparaison**

    - Accéder aux deux serveurs via navigateur
    - Comparer les pages d'accueil
    - Noter les différences

4. **Nettoyage**
    ```bash
    docker stop serveur-nginx serveur-apache
    docker rm serveur-nginx serveur-apache
    ```

### Questions

1. Quelle est la différence entre les pages d'accueil ?
2. Combien de temps a pris le démarrage de chaque serveur ?
3. Quelle est la taille de chaque image ?

---

## TP3 : Mode interactif

### Objectif

Maîtriser le mode interactif et comprendre l'isolation des conteneurs.

### Scenario

Vous devez tester un script dans différents environnements Linux.

### Instructions

1. **Ubuntu**

    ```bash
    docker run -it --name test-ubuntu ubuntu bash
    ```

    Dans le conteneur :

    ```bash
    # Vérifier l'OS
    cat /etc/os-release

    # Créer un fichier
    echo "Test Ubuntu" > /tmp/test.txt
    cat /tmp/test.txt

    # Installer curl
    apt update
    apt install curl -y
    curl --version

    # Sortir
    exit
    ```

2. **Alpine Linux**

    ```bash
    docker run -it --name test-alpine alpine sh
    ```

    Dans le conteneur :

    ```bash
    # Vérifier l'OS
    cat /etc/os-release

    # Créer un fichier
    echo "Test Alpine" > /tmp/test.txt
    cat /tmp/test.txt

    # Installer curl
    apk add curl
    curl --version

    # Sortir
    exit
    ```

3. **Test de persistance**

    ```bash
    # Redémarrer le conteneur Ubuntu
    docker start test-ubuntu
    docker exec -it test-ubuntu bash

    # Vérifier si nos modifications sont toujours là
    cat /tmp/test.txt
    curl --version

    exit
    ```

### Questions

1. Quelle est la différence de taille entre Ubuntu et Alpine ?
2. Les modifications sont-elles conservées après redémarrage ?
3. Pourquoi Alpine utilise `apk` au lieu de `apt` ?

---

## TP4 : Projet final - Site web simple

### Objectif

Créer votre premier site web containerisé.

### Scenario

Vous devez déployer un site web statique avec Nginx.

### Instructions

1. **Créer le contenu web**

    ```bash
    # Créer un dossier pour votre site
    mkdir mon-site-web
    cd mon-site-web
    ```

2. **Créer index.html**

    ```html
    <!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8" />
            <meta
                name="viewport"
                content="width=device-width, initial-scale=1.0"
            />
            <title>Mon Premier Site Dockerisé</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: linear-gradient(
                        135deg,
                        #667eea 0%,
                        #764ba2 100%
                    );
                    color: white;
                    text-align: center;
                    padding: 50px;
                }
                .container {
                    background: rgba(255, 255, 255, 0.1);
                    padding: 30px;
                    border-radius: 15px;
                    max-width: 600px;
                    margin: 0 auto;
                }
                .docker-logo {
                    font-size: 3em;
                    margin: 20px 0;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="docker-logo">🐳</div>
                <h1>Mon Premier Site Dockerisé !</h1>
                <p>
                    Félicitations ! Vous avez réussi à containeriser votre site
                    web.
                </p>
                <p><strong>Module 1 terminé avec succès !</strong></p>
                <p>Prochaine étape : Module 2 - Installation et premiers pas</p>
            </div>
        </body>
    </html>
    ```

3. **Lancer avec Docker**

    ```bash
    # Depuis le dossier contenant index.html
    docker run -d -p 8080:80 -v $(pwd):/usr/share/nginx/html --name mon-site nginx
    ```

4. **Tester**

    - Ouvrir http://localhost:8080
    - Modifier index.html
    - Rafraîchir le navigateur

5. **Analyser**

    ```bash
    # Voir les logs d'accès
    docker logs mon-site

    # Voir les processus dans le conteneur
    docker exec mon-site ps aux

    # Voir l'utilisation des ressources
    docker stats mon-site
    ```

### Bonus

-   Ajouter une page CSS séparée
-   Créer une page "À propos"
-   Ajouter du JavaScript simple

### Livrables

-   Code HTML de votre site
-   Screenshot du site dans le navigateur
-   Commandes utilisées
-   Observations sur les logs et stats

---

## 📊 Grille d'évaluation

| Critère               | Points | Description                                               |
| --------------------- | ------ | --------------------------------------------------------- |
| **Installation**      | 25 pts | Docker correctement installé et fonctionnel               |
| **Commandes de base** | 25 pts | Maîtrise des commandes docker run, ps, logs               |
| **Mode interactif**   | 25 pts | Utilisation correcte de -it, compréhension de l'isolation |
| **Projet final**      | 25 pts | Site web fonctionnel avec volumes                         |

**Total : 100 points**

### Barème

-   90-100 pts : Excellent ⭐⭐⭐
-   75-89 pts : Bien ⭐⭐
-   60-74 pts : Satisfaisant ⭐
-   < 60 pts : À reprendre 🔄

---

## 🆘 Aide et dépannage

### Problèmes courants

**1. "docker: command not found"**

-   Solution : Vérifier l'installation, redémarrer le terminal

**2. "Permission denied"**

-   Linux : Ajouter l'utilisateur au groupe docker
-   Windows : Vérifier que Docker Desktop est lancé

**3. "Port already in use"**

-   Solution : Changer le port ou arrêter le service qui l'utilise

**4. Image ne se télécharge pas**

-   Vérifier la connexion internet
-   Essayer `docker pull <image>` manuellement

### Commandes de dépannage

```bash
# Voir tous les conteneurs
docker ps -a

# Voir toutes les images
docker images

# Libérer de l'espace
docker system prune

# Voir les logs détaillés
docker logs -f <container_name>

# Redémarrer Docker (Linux)
sudo systemctl restart docker
```

### Ressources d'aide

-   [Docker Documentation](https://docs.docker.com/)
-   [Docker Community Forum](https://forums.docker.com/)
-   [Stack Overflow - Docker](https://stackoverflow.com/questions/tagged/docker)

---

## ✅ Validation des acquis

Avant de passer au module suivant, assurez-vous que vous pouvez :

-   [ ] Expliquer la différence entre image et conteneur
-   [ ] Installer Docker sur votre OS
-   [ ] Lancer un conteneur avec `docker run`
-   [ ] Utiliser les options `-d`, `-p`, `-it`, `--name`
-   [ ] Lister images et conteneurs
-   [ ] Arrêter et supprimer des conteneurs
-   [ ] Comprendre le concept de volumes (TP4)

**🎉 Si tous les points sont validés, vous êtes prêt pour le Module 2 !**
