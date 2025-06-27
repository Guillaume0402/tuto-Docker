# Module 5 : Réseaux Docker - Communication entre Conteneurs

## 🎯 Objectifs pédagogiques

-   Comprendre les concepts de réseau Docker
-   Maîtriser les différents types de réseaux
-   Connecter plusieurs conteneurs efficacement
-   Configurer la communication inter-conteneurs
-   Sécuriser les réseaux Docker

## 📋 Prérequis

-   Avoir terminé les modules 1 à 4
-   Comprendre les bases des réseaux TCP/IP
-   Docker Desktop installé et fonctionnel

## 📚 Contenu théorique

### Pourquoi les réseaux Docker ?

Par défaut, les conteneurs Docker sont isolés. Les réseaux permettent :

-   **Communication** entre conteneurs
-   **Isolation** sécurisée des services
-   **Discovery** automatique des services
-   **Load balancing** entre instances

### Architecture réseau Docker

Docker utilise un modèle de réseau basé sur :

-   **Bridge networks** : Réseaux privés sur un seul hôte
-   **Host networks** : Utilise directement le réseau de l'hôte
-   **Overlay networks** : Réseaux multi-hôtes (Docker Swarm)
-   **Macvlan networks** : Attribution d'adresses MAC aux conteneurs

## 🌐 Types de réseaux Docker

### 1. Bridge Network (par défaut)

Réseau privé interne à l'hôte Docker :

```bash
# Réseau bridge par défaut
docker network ls

# Créer un réseau bridge personnalisé
docker network create mon-reseau

# Inspecter un réseau
docker network inspect mon-reseau
```

**Caractéristiques :**

-   Isolation des conteneurs
-   Communication via IP ou nom de conteneur
-   Port mapping vers l'hôte
-   DNS intégré pour la résolution de noms

### 2. Host Network

Partage du réseau de l'hôte :

```bash
# Utiliser le réseau de l'hôte
docker run --network host nginx
```

**Avantages :**

-   Meilleures performances
-   Pas de NAT
-   Accès direct aux ports de l'hôte

**Inconvénients :**

-   Moins de sécurité
-   Conflits de ports possibles

### 3. None Network

Aucune connectivité réseau :

```bash
# Conteneur sans réseau
docker run --network none alpine
```

### 4. Overlay Network

Pour les clusters multi-hôtes :

```bash
# Créer un réseau overlay (Docker Swarm)
docker network create --driver overlay mon-overlay
```

## 🔧 Gestion des réseaux

### Commandes de base

```bash
# Lister les réseaux
docker network ls

# Créer un réseau
docker network create [OPTIONS] NETWORK_NAME

# Inspecter un réseau
docker network inspect NETWORK_NAME

# Connecter un conteneur à un réseau
docker network connect NETWORK_NAME CONTAINER

# Déconnecter un conteneur
docker network disconnect NETWORK_NAME CONTAINER

# Supprimer un réseau
docker network rm NETWORK_NAME
```

### Options avancées

```bash
# Réseau avec sous-réseau personnalisé
docker network create --subnet=192.168.1.0/24 mon-reseau

# Réseau avec passerelle personnalisée
docker network create --gateway=192.168.1.1 mon-reseau

# Réseau avec options de driver
docker network create --driver bridge --opt com.docker.network.bridge.name=mybr0 mon-reseau
```

## 🏗️ Communication inter-conteneurs

### Par nom de conteneur

```bash
# Créer un réseau personnalisé
docker network create app-network

# Lancer une base de données
docker run -d --name db --network app-network postgres:13

# Lancer une application qui se connecte à 'db'
docker run -d --name app --network app-network -p 3000:3000 myapp
```

Dans le code de l'application :

```javascript
// L'application peut se connecter via le nom 'db'
const dbUrl = "postgresql://user:pass@db:5432/mydb";
```

### Par adresse IP

```bash
# Obtenir l'IP d'un conteneur
docker inspect db | grep IPAddress

# Se connecter via l'IP (moins recommandé)
const dbUrl = 'postgresql://user:pass@172.18.0.2:5432/mydb';
```

### Communication avec l'hôte

```bash
# Accéder à un service sur l'hôte depuis un conteneur
# Utiliser host.docker.internal (Windows/Mac)
# Ou l'IP de l'interface docker0 (Linux)
```

## 🔒 Sécurité réseau

### Isolation par réseau

```bash
# Réseau pour les services publics
docker network create frontend

# Réseau pour les services internes
docker network create backend

# Base de données seulement sur le réseau backend
docker run -d --name db --network backend postgres

# API sur les deux réseaux
docker run -d --name api myapi
docker network connect frontend api
docker network connect backend api
```

### Filtrage de ports

```bash
# Exposer seulement les ports nécessaires
docker run -d -p 80:80 --name web nginx  # Port 80 uniquement
docker run -d --name db postgres          # Aucun port exposé
```

## 📊 Monitoring et debugging

### Inspection des réseaux

```bash
# Voir tous les réseaux et leurs conteneurs
docker network ls
docker network inspect bridge

# Voir les connexions réseau d'un conteneur
docker inspect CONTAINER | grep -A 20 NetworkSettings
```

### Tests de connectivité

```bash
# Tester la connexion entre conteneurs
docker exec container1 ping container2
docker exec container1 curl http://container2:8080/health

# Tracer les routes réseau
docker exec container1 traceroute container2
```

### Outils de debugging

```bash
# Netshoot : conteneur avec outils réseau
docker run --rm -it --network container:CONTAINER nicolaka/netshoot

# Tcpdump pour capturer le trafic
docker exec container tcpdump -i eth0
```

## 🚀 Exemples pratiques

### Stack LAMP classique

```bash
# Créer le réseau
docker network create lamp-network

# Base de données MySQL
docker run -d \
  --name mysql \
  --network lamp-network \
  -e MYSQL_ROOT_PASSWORD=secret \
  mysql:8.0

# Serveur web Apache + PHP
docker run -d \
  --name apache \
  --network lamp-network \
  -p 80:80 \
  -v $(pwd)/html:/var/www/html \
  php:apache
```

### Microservices avec API Gateway

```bash
# Réseau pour les microservices
docker network create microservices

# Service utilisateurs
docker run -d --name users-service --network microservices users-api

# Service commandes
docker run -d --name orders-service --network microservices orders-api

# API Gateway
docker run -d --name gateway --network microservices -p 8080:8080 api-gateway
```

### Load Balancer avec Nginx

```bash
# Réseau pour l'application
docker network create app-tier

# Plusieurs instances de l'application
docker run -d --name app1 --network app-tier myapp
docker run -d --name app2 --network app-tier myapp
docker run -d --name app3 --network app-tier myapp

# Load balancer Nginx
docker run -d --name lb --network app-tier -p 80:80 nginx-lb
```

## 📈 Bonnes pratiques

### 1. Utiliser des réseaux personnalisés

```bash
# ❌ Éviter le réseau bridge par défaut
docker run -d postgres

# ✅ Créer des réseaux spécifiques
docker network create db-network
docker run -d --network db-network postgres
```

### 2. Séparer les couches

```bash
# Frontend public
docker network create frontend

# Backend privé
docker network create backend

# Base de données très privée
docker network create database
```

### 3. Utiliser la résolution DNS

```bash
# ✅ Utiliser les noms de conteneur
database_url = "postgres://db:5432/myapp"

# ❌ Éviter les adresses IP hardcodées
database_url = "postgres://172.18.0.2:5432/myapp"
```

### 4. Documenter la topologie réseau

```yaml
# docker-compose.yml avec réseaux explicites
version: "3.8"
services:
    web:
        networks:
            - frontend
            - backend
    api:
        networks:
            - backend
            - database
    db:
        networks:
            - database

networks:
    frontend:
    backend:
    database:
```

## 💡 Cas d'usage avancés

### Service Mesh avec Consul Connect

```bash
# Réseau pour service mesh
docker network create consul-network

# Agent Consul
docker run -d --name consul --network consul-network consul

# Services avec sidecar proxy
docker run -d --name app --network consul-network myapp-with-consul
```

### VPN entre conteneurs

```bash
# Réseau overlay sécurisé
docker network create --driver overlay --opt encrypted vpn-network
```

## 📱 Docker Compose et réseaux

### Réseaux automatiques

```yaml
version: "3.8"
services:
    web:
        image: nginx
        depends_on:
            - api
    api:
        image: myapi
        depends_on:
            - db
    db:
        image: postgres
```

### Réseaux personnalisés

```yaml
version: "3.8"
services:
    web:
        networks:
            - frontend
    api:
        networks:
            - frontend
            - backend
    db:
        networks:
            - backend

networks:
    frontend:
        driver: bridge
    backend:
        driver: bridge
        internal: true # Pas d'accès externe
```

## 🔍 Troubleshooting réseau

### Problèmes courants

1. **Conteneurs ne se trouvent pas** : Vérifier qu'ils sont sur le même réseau
2. **Problèmes de DNS** : Utiliser les noms de conteneur corrects
3. **Ports non accessibles** : Vérifier les mappings de ports
4. **Firewall** : Vérifier les règles iptables

### Outils de diagnostic

```bash
# Voir les connexions réseau
docker network ls
docker network inspect NETWORK

# Tester la connectivité
docker exec container ping autre-container
docker exec container nslookup autre-container

# Analyser les logs réseau
docker logs container
journalctl -u docker
```

## 📚 Ressources supplémentaires

-   [Documentation Docker Networking](https://docs.docker.com/network/)
-   [Guide des réseaux Docker](https://docs.docker.com/network/bridge/)
-   [Tutoriel Networking avancé](https://docs.docker.com/network/tutorials/)

---

_Ce module vous donne toutes les clés pour maîtriser les réseaux Docker. Continuez avec le TP pour pratiquer !_
