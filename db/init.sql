-- Script d'initialisation de la base de données
-- Ce script sera exécuté automatiquement lors du premier démarrage du conteneur MySQL

CREATE DATABASE IF NOT EXISTS tuto_docker;

USE tuto_docker;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des cours
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    content LONGTEXT,
    instructor_id INT,
    price DECIMAL(10, 2) DEFAULT 0.00,
    duration_hours INT DEFAULT 0,
    level ENUM(
        'débutant',
        'intermédiaire',
        'avancé'
    ) DEFAULT 'débutant',
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users (id) ON DELETE SET NULL
);

-- Table des messages de contact
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des inscriptions aux cours
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    progress DECIMAL(5, 2) DEFAULT 0.00,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses (id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- Insertion de données d'exemple
INSERT INTO
    users (
        username,
        email,
        password,
        first_name,
        last_name
    )
VALUES (
        'admin',
        'admin@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Admin',
        'User'
    ),
    (
        'john_doe',
        'john@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'John',
        'Doe'
    );

INSERT INTO
    courses (
        title,
        description,
        content,
        instructor_id,
        price,
        duration_hours,
        level
    )
VALUES
    -- NIVEAU DÉBUTANT (Modules 1-4)
    (
        'Module 1 : Introduction et concepts fondamentaux',
        'Découvrez ce qu\'est Docker, pourquoi l\'utiliser, et les concepts de base : conteneurs vs machines virtuelles, images, registres.',
        'Ce module couvre les concepts fondamentaux de Docker : qu\'est-ce que la conteneurisation, comparaison avec les machines virtuelles, architecture Docker, images et conteneurs, Docker Hub et registres.',
        1,
        29.99,
        4,
        'débutant'
    ),
    (
        'Module 2 : Installation et premiers pas',
        'Installation de Docker sur différents OS, configuration initiale, commandes de base et premier conteneur "Hello World".',
        'Installation Docker Desktop sur Windows/Mac/Linux, configuration initiale, première commande docker run, gestion des conteneurs de base.',
        1,
        24.99,
        3,
        'débutant'
    ),
    (
        'Module 3 : Images Docker',
        'Gestion des images : pull/push, création, optimisation, bonnes pratiques. Maîtrisez le système d\'images Docker.',
        'Téléchargement et envoi d\'images, création d\'images personnalisées, optimisation de la taille, layers et cache, bonnes pratiques.',
        1,
        34.99,
        5,
        'débutant'
    ),
    (
        'Module 4 : Conteneurs - Gestion avancée',
        'Cycle de vie des conteneurs, volumes, ports, variables d\'environnement, logs et monitoring de base.',
        'Cycle de vie complet des conteneurs, gestion des ports et volumes, variables d\'environnement, logs et debugging.',
        1,
        39.99,
        6,
        'débutant'
    ),

-- NIVEAU INTERMÉDIAIRE (Modules 5-10)
(
    'Module 5 : Dockerfile - Maîtrise complète',
    'Syntaxe Dockerfile, instructions avancées, multi-stage builds, optimisation des layers et cache.',
    'Syntaxe complète Dockerfile, instructions avancées, multi-stage builds, optimisation des layers, gestion du cache.',
    1,
    44.99,
    7,
    'intermédiaire'
),
(
    'Module 6 : Docker Compose - Applications multi-conteneurs',
    'Orchestration avec Docker Compose : services, réseaux, volumes, environnements et déploiement.',
    'Docker Compose complet : fichiers YAML, services multiples, réseaux custom, volumes nommés, environnements.',
    1,
    54.99,
    8,
    'intermédiaire'
),
(
    'Module 7 : Réseaux Docker',
    'Types de réseaux, communication inter-conteneurs, isolation, bridge, host, overlay et configuration avancée.',
    'Réseaux Docker : bridge, host, overlay, custom networks, communication inter-conteneurs, isolation réseau.',
    1,
    49.99,
    6,
    'intermédiaire'
),
(
    'Module 8 : Stockage et volumes',
    'Persistance des données : volumes nommés, bind mounts, tmpfs, stratégies de sauvegarde et performance.',
    'Stockage Docker : volumes nommés, bind mounts, tmpfs, persistance des données, sauvegarde et performance.',
    1,
    42.99,
    5,
    'intermédiaire'
),
(
    'Module 9 : Sécurité Docker',
    'Bonnes pratiques de sécurité : utilisateurs non-root, secrets, scanning d\'images, politiques de sécurité.',
    'Sécurité Docker : utilisateurs non-root, secrets management, scanning d\'images, politiques de sécurité, hardening.',
    1,
    59.99,
    7,
    'intermédiaire'
),
(
    'Module 10 : Docker Registry et distribution',
    'Docker Hub, registres privés, Harbor, distribution d\'images, versionning et gestion des artifacts.',
    'Registres Docker : Docker Hub, registres privés, Harbor, distribution d\'images, versionning, artifacts.',
    1,
    47.99,
    6,
    'intermédiaire'
),

-- NIVEAU AVANCÉ (Modules 11-18)
(
    'Module 11 : Docker Swarm - Orchestration native',
    'Clusters Docker Swarm, services, scaling, load balancing, rolling updates et haute disponibilité.',
    'Docker Swarm : clusters, services, scaling automatique, load balancing, rolling updates, haute disponibilité.',
    1,
    79.99,
    10,
    'avancé'
),
(
    'Module 12 : Introduction à Kubernetes',
    'Migration de Docker vers Kubernetes : pods, services, deployments, ingress et écosystème K8s.',
    'Kubernetes : migration depuis Docker, pods, services, deployments, ingress, écosystème et outils.',
    1,
    89.99,
    12,
    'avancé'
),
(
    'Module 13 : CI/CD avec Docker',
    'Intégration continue : Jenkins, GitLab CI, GitHub Actions, automatisation des builds et déploiements.',
    'CI/CD Docker : Jenkins, GitLab CI, GitHub Actions, automatisation builds, tests et déploiements.',
    1,
    74.99,
    9,
    'avancé'
),
(
    'Module 14 : Monitoring et observabilité',
    'Supervision des conteneurs : Prometheus, Grafana, ELK Stack, tracing distribué et métriques.',
    'Monitoring Docker : Prometheus, Grafana, ELK Stack, tracing distribué, métriques et alerting.',
    1,
    69.99,
    8,
    'avancé'
),
(
    'Module 15 : Performance et optimisation',
    'Optimisation des images, ressources, cache, profiling, benchmarking et tuning des performances.',
    'Performance Docker : optimisation images, ressources, cache, profiling, benchmarking, tuning.',
    1,
    64.99,
    7,
    'avancé'
),

-- PROJETS PRATIQUES (Modules 16-18)
(
    'Module 16 : Projet - Application Web complète',
    'Projet complet : application web avec base de données, reverse proxy, SSL, monitoring et déploiement.',
    'Projet complet : stack LAMP dockerisée, reverse proxy Nginx, SSL Let\'s Encrypt, monitoring Prometheus.',
    1,
    99.99,
    15,
    'avancé'
),
(
    'Module 17 : Docker avec Symfony',
    'Containerisation d\'applications Symfony : environnements dev/prod, tests, cache Redis, base de données.',
    'Symfony + Docker : environnements optimisés, Doctrine, cache Redis, tests automatisés, déploiement.',
    1,
    84.99,
    12,
    'avancé'
),
(
    'Module 18 : Docker avec Node.js et microservices',
    'Architecture microservices avec Node.js : API Gateway, communication async, monitoring distribué.',
    'Node.js + Docker : microservices, API Gateway, communication async, monitoring distribué, scalabilité.',
    1,
    94.99,
    14,
    'avancé'
);

INSERT INTO
    messages (name, email, subject, message)
VALUES (
        'Jane Smith',
        'jane@example.com',
        'Question sur les cours',
        'Bonjour, j\'aimerais avoir plus d\'informations sur vos cours.'
    );