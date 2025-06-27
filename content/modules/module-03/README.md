# 🐳 Module 3 : Volumes et gestion des données

**Durée estimée :** 4 heures  
**Niveau :** Intermédiaire  
**Prérequis :** Modules 1 et 2 terminés

## 🎯 Objectifs pédagogiques

À la fin de ce module, vous serez capable de :

-   ✅ **Comprendre** le problème de persistance des données dans les conteneurs
-   ✅ **Différencier** les types de volumes Docker
-   ✅ **Créer et gérer** des volumes Docker
-   ✅ **Partager** des données entre conteneurs
-   ✅ **Implémenter** des sauvegardes et restaurations
-   ✅ **Optimiser** les performances de stockage

## 📚 Plan du module

### 1. Problématique des données dans les conteneurs (45 min)

### 2. Types de volumes Docker (60 min)

### 3. Volumes nommés et bind mounts (90 min)

### 4. Partage de données entre conteneurs (60 min)

### 5. Sauvegarde et restauration (45 min)

---

## 1. 🗂️ Problématique des données dans les conteneurs

### Le problème de l'éphémérité

Les conteneurs Docker sont **éphémères** par nature :

```bash
# Création d'un conteneur avec données
docker run -it --name test-data ubuntu bash
# Dans le conteneur : echo "Données importantes" > /tmp/fichier.txt

# Suppression du conteneur
docker rm test-data

# 💥 Les données sont perdues définitivement !
```

### Couches en lecture seule vs lecture-écriture

```
Conteneur en cours d'exécution:
┌─────────────────────────────────┐
│     Couche R/W (Container)      │ ← Données temporaires
├─────────────────────────────────┤
│     Couche R/O (Image)          │ ← Application
├─────────────────────────────────┤
│     Couche R/O (Dependencies)   │ ← Dépendances
├─────────────────────────────────┤
│     Couche R/O (Base OS)        │ ← Système de base
└─────────────────────────────────┘
```

### Cas d'usage nécessitant de la persistance

#### 🗄️ Bases de données

```bash
# PostgreSQL sans volume = données perdues au redémarrage
docker run --name postgres-test postgres:13
docker stop postgres-test
docker start postgres-test  # Base vide !
```

#### 📁 Fichiers utilisateur

```bash
# Application web avec uploads
# Redémarrage = perte des fichiers uploadés
```

#### 📊 Logs et métriques

```bash
# Logs applicatifs pour debugging
# Configuration et cache
```

---

## 2. 📦 Types de volumes Docker

Docker propose **3 types principaux** de stockage persistent :

### 1. Volumes Docker (recommandé)

```bash
# Création d'un volume
docker volume create mon-volume

# Utilisation
docker run -v mon-volume:/data ubuntu echo "Hello" > /data/test.txt
```

**Avantages :**

-   ✅ Géré entièrement par Docker
-   ✅ Portable entre différents hôtes
-   ✅ Sauvegarde et restauration simplifiées
-   ✅ Pilotes de stockage avancés

### 2. Bind Mounts

```bash
# Montage d'un répertoire hôte
docker run -v /chemin/hote:/chemin/conteneur ubuntu
```

**Avantages :**

-   ✅ Accès direct aux fichiers depuis l'hôte
-   ✅ Idéal pour le développement
-   ✅ Partage simple avec l'OS hôte

**Inconvénients :**

-   ❌ Dépendant du système de fichiers hôte
-   ❌ Problèmes de permissions potentiels

### 3. tmpfs Mounts (mémoire)

```bash
# Stockage en mémoire RAM
docker run --tmpfs /tmp ubuntu
```

**Usage :**

-   Données temporaires sensibles
-   Cache haute performance
-   Secrets temporaires

### Comparaison visuelle

```
┌─────────────────┬─────────────────┬─────────────────┐
│   Docker Volume │   Bind Mount    │   tmpfs Mount   │
├─────────────────┼─────────────────┼─────────────────┤
│ /var/lib/docker │ /host/path      │ Mémoire RAM     │
│ Géré par Docker │ Géré par l'OS   │ Temporaire      │
│ Portable        │ Développement   │ Performance     │
│ Production ✅   │ Dev/Test ✅     │ Cache ✅        │
└─────────────────┴─────────────────┴─────────────────┘
```

---

## 3. 🔧 Volumes nommés et bind mounts

### Gestion des volumes Docker

#### Création et listage

```bash
# Créer un volume
docker volume create data-volume
docker volume create --driver local log-volume

# Lister les volumes
docker volume ls

# Inspecter un volume
docker volume inspect data-volume
```

#### Utilisation dans les conteneurs

```bash
# Syntaxe courte
docker run -v data-volume:/app/data nginx

# Syntaxe longue (recommandée)
docker run --mount source=data-volume,target=/app/data nginx

# Lecture seule
docker run --mount source=data-volume,target=/app/data,readonly nginx
```

### Exemple concret : Base de données PostgreSQL

```bash
# 1. Créer un volume pour les données
docker volume create postgres-data

# 2. Lancer PostgreSQL avec volume persistent
docker run -d \
  --name ma-postgres \
  -e POSTGRES_PASSWORD=motdepasse \
  -v postgres-data:/var/lib/postgresql/data \
  -p 5432:5432 \
  postgres:13

# 3. Tester la persistance
docker exec -it ma-postgres psql -U postgres -c "CREATE DATABASE test_db;"

# 4. Arrêter et supprimer le conteneur
docker stop ma-postgres
docker rm ma-postgres

# 5. Redémarrer avec le même volume
docker run -d \
  --name ma-postgres-2 \
  -e POSTGRES_PASSWORD=motdepasse \
  -v postgres-data:/var/lib/postgresql/data \
  -p 5432:5432 \
  postgres:13

# 6. Vérifier que les données sont toujours là
docker exec -it ma-postgres-2 psql -U postgres -c "\\l"
# test_db est toujours présente ! ✅
```

### Bind Mounts pour le développement

#### Exemple : Développement d'application web

```bash
# Structure du projet
mon-projet/
├── src/
│   ├── index.html
│   ├── style.css
│   └── script.js
└── Dockerfile

# Dockerfile
FROM nginx:alpine
COPY src/ /usr/share/nginx/html/
```

```bash
# Développement avec bind mount
docker run -d \
  --name dev-server \
  -p 8080:80 \
  -v $(pwd)/src:/usr/share/nginx/html \
  nginx:alpine

# Modifications des fichiers visibles immédiatement !
# Pas besoin de rebuild à chaque changement
```

#### Bind mount avec Node.js et nodemon

```bash
# Dockerfile de développement
FROM node:16-alpine
WORKDIR /app
COPY package*.json ./
RUN npm install
RUN npm install -g nodemon
CMD ["nodemon", "server.js"]
```

```bash
# Lancement en mode développement
docker run -d \
  --name node-dev \
  -p 3000:3000 \
  -v $(pwd):/app \
  -v /app/node_modules \
  mon-app:dev

# Les changements de code déclenchent un redémarrage automatique
```

---

## 4. 🔄 Partage de données entre conteneurs

### Volumes partagés

#### Scenario : Application web + Worker

```bash
# 1. Créer un volume partagé
docker volume create shared-data

# 2. Conteneur web qui génère des fichiers
docker run -d \
  --name web-app \
  -v shared-data:/app/uploads \
  -p 8080:80 \
  nginx:alpine

# 3. Conteneur worker qui traite les fichiers
docker run -d \
  --name file-processor \
  -v shared-data:/data \
  alpine:latest \
  sh -c "while true; do ls -la /data; sleep 30; done"

# Les deux conteneurs accèdent aux mêmes données !
```

### Containers with volumes-from (legacy)

```bash
# Conteneur de données (ancienne méthode)
docker create --name data-container -v /data alpine

# Partage avec d'autres conteneurs
docker run --volumes-from data-container alpine ls /data
```

### Pattern : Sidecar containers

```bash
# Conteneur principal
docker run -d \
  --name app \
  -v logs:/var/log \
  mon-application

# Conteneur sidecar pour les logs
docker run -d \
  --name log-shipper \
  -v logs:/logs \
  fluent/fluent-bit
```

---

## 5. 💾 Sauvegarde et restauration

### Sauvegarde d'un volume

#### Méthode 1 : Tar via conteneur temporaire

```bash
# Créer une sauvegarde
docker run --rm \
  -v mon-volume:/data \
  -v $(pwd):/backup \
  alpine:latest \
  tar czf /backup/backup-$(date +%Y%m%d).tar.gz -C /data .

# Vérifier la sauvegarde
ls -lh backup-*.tar.gz
```

#### Méthode 2 : Script automatisé

```bash
#!/bin/bash
# backup-volume.sh

VOLUME_NAME=$1
BACKUP_DIR="./backups"
DATE=$(date +%Y%m%d_%H%M%S)

if [ -z "$VOLUME_NAME" ]; then
    echo "Usage: $0 <volume-name>"
    exit 1
fi

mkdir -p $BACKUP_DIR

echo "🗄️  Sauvegarde du volume: $VOLUME_NAME"
docker run --rm \
  -v $VOLUME_NAME:/data:ro \
  -v $(pwd)/$BACKUP_DIR:/backup \
  alpine:latest \
  tar czf /backup/${VOLUME_NAME}_${DATE}.tar.gz -C /data .

echo "✅ Sauvegarde terminée: ${VOLUME_NAME}_${DATE}.tar.gz"
ls -lh $BACKUP_DIR/${VOLUME_NAME}_${DATE}.tar.gz
```

### Restauration d'un volume

```bash
# Restaurer depuis une sauvegarde
docker run --rm \
  -v mon-volume-restaure:/data \
  -v $(pwd):/backup \
  alpine:latest \
  tar xzf /backup/backup-20231201.tar.gz -C /data

# Vérifier la restauration
docker run --rm -v mon-volume-restaure:/data alpine ls -la /data
```

### Sauvegarde de base de données

#### PostgreSQL

```bash
# Sauvegarde
docker exec ma-postgres pg_dump -U postgres ma_base > backup.sql

# Restauration
docker exec -i ma-postgres psql -U postgres ma_base < backup.sql
```

#### MySQL

```bash
# Sauvegarde
docker exec ma-mysql mysqldump -u root -p ma_base > backup.sql

# Restauration
docker exec -i ma-mysql mysql -u root -p ma_base < backup.sql
```

### Automatisation avec cron

```bash
# Ajouter au crontab
# Sauvegarde quotidienne à 2h du matin
0 2 * * * /path/to/backup-volume.sh postgres-data

# Nettoyage des sauvegardes anciennes (garder 7 jours)
0 3 * * * find /path/to/backups -name "*.tar.gz" -mtime +7 -delete
```

---

## 6. ⚡ Optimisation des performances

### Choisir le bon pilote de volume

#### Local driver (par défaut)

```bash
docker volume create --driver local mon-volume
```

#### Pilotes spécialisés

```bash
# NFS pour le partage réseau
docker volume create --driver local \
  --opt type=nfs \
  --opt o=addr=192.168.1.100,rw \
  --opt device=:/path/to/dir \
  nfs-volume

# SMB/CIFS pour Windows
docker volume create --driver local \
  --opt type=cifs \
  --opt o=username=user,password=pass \
  --opt device=//server/share \
  smb-volume
```

### Optimisation des performances

#### Paramètres de montage

```bash
# Optimisations pour les bases de données
docker run -d \
  --name postgres-optimized \
  -v postgres-data:/var/lib/postgresql/data:Z \
  -e POSTGRES_PASSWORD=secret \
  postgres:13
```

#### tmpfs pour les données temporaires

```bash
# Cache en mémoire
docker run -d \
  --name redis-cache \
  --tmpfs /tmp:rw,size=100m \
  redis:alpine
```

### Monitoring des volumes

```bash
# Espace utilisé par les volumes
docker system df -v

# Informations détaillées
docker volume inspect mon-volume

# Cleanup des volumes non utilisés
docker volume prune
```

---

## 🧪 Laboratoire pratique

### Projet : Stack LAMP avec persistance

Créer une stack LAMP (Linux, Apache, MySQL, PHP) avec persistance complète des données.

#### Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Web Server    │    │    Database     │    │   File Storage  │
│   (Apache+PHP)  │────│     (MySQL)     │    │   (Uploads)     │
│                 │    │                 │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         v                       v                       v
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   web-content   │    │   mysql-data    │    │   user-uploads  │
│    (Volume)     │    │    (Volume)     │    │    (Volume)     │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

#### Implémentation

1. **Création des volumes**

```bash
docker volume create mysql-data
docker volume create web-content
docker volume create user-uploads
```

2. **Base de données MySQL**

```bash
docker run -d \
  --name lamp-mysql \
  -e MYSQL_ROOT_PASSWORD=rootpass \
  -e MYSQL_DATABASE=webapp \
  -e MYSQL_USER=webuser \
  -e MYSQL_PASSWORD=webpass \
  -v mysql-data:/var/lib/mysql \
  mysql:8.0
```

3. **Serveur web Apache+PHP**

```bash
docker run -d \
  --name lamp-web \
  --link lamp-mysql:mysql \
  -p 8080:80 \
  -v web-content:/var/www/html \
  -v user-uploads:/var/www/html/uploads \
  php:7.4-apache
```

4. **Test de persistance**

```bash
# Créer du contenu
docker exec lamp-web bash -c "echo '<?php phpinfo(); ?>' > /var/www/html/info.php"

# Arrêter et redémarrer les conteneurs
docker stop lamp-web lamp-mysql
docker start lamp-mysql lamp-web

# Vérifier que le contenu persiste
curl http://localhost:8080/info.php
```

---

## 📝 Résumé du module

### Points clés retenus

1. **Persistance** : Les volumes résolvent l'éphémérité des conteneurs
2. **Types de volumes** : Docker volumes, bind mounts, tmpfs
3. **Partage** : Volumes partagés entre conteneurs
4. **Sauvegarde** : Stratégies de backup et restauration
5. **Performance** : Optimisation du stockage

### Commandes essentielles

```bash
# Gestion des volumes
docker volume create nom-volume
docker volume ls
docker volume inspect nom-volume
docker volume rm nom-volume
docker volume prune

# Utilisation
docker run -v volume-name:/path/in/container image
docker run --mount source=volume,target=/path image

# Sauvegarde
docker run --rm -v volume:/data -v $(pwd):/backup alpine tar czf /backup/backup.tar.gz -C /data .
```

### Bonnes pratiques

1. **Utiliser des volumes Docker** pour la production
2. **Bind mounts** pour le développement uniquement
3. **Sauvegarder régulièrement** les données critiques
4. **Monitorer l'espace disque** des volumes
5. **Nettoyer** les volumes non utilisés

---

## 🎯 Objectifs du prochain module

Au **Module 4**, nous découvrirons :

-   Le réseau Docker et les communications entre conteneurs
-   Les différents types de réseaux Docker
-   La sécurité réseau et l'isolation
-   Les stratégies de load balancing
