<div class="container py-5">
    <!-- En-tête avec présentation du parcours -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center mb-4">
                <h1 class="fw-bold mb-3">
                    <i class="fab fa-docker me-2 text-primary"></i>
                    Formation Docker Complète
                </h1>
                <p class="lead text-muted">
                    Maîtrisez Docker de A à Z avec notre parcours pédagogique progressif en 18 modules
                </p>
            </div>

            <!-- Statistiques du parcours -->
            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="card bg-light border-0 text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-graduation-cap fa-2x text-primary mb-2"></i>
                            <h4 class="fw-bold">18</h4>
                            <small class="text-muted">Modules de formation</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card bg-light border-0 text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-clock fa-2x text-success mb-2"></i>
                            <h4 class="fw-bold">150+</h4>
                            <small class="text-muted">Heures de contenu</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card bg-light border-0 text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x text-warning mb-2"></i>
                            <h4 class="fw-bold">1200+</h4>
                            <small class="text-muted">Étudiants inscrits</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card bg-light border-0 text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-project-diagram fa-2x text-info mb-2"></i>
                            <h4 class="fw-bold">3</h4>
                            <small class="text-muted">Projets complets</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progression pédagogique -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-route me-2"></i>
                        Parcours pédagogique progressif
                    </h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-info me-2">1-4</span>
                                <strong>Fondamentaux</strong>
                            </div>
                            <p class="small text-muted">Concepts de base, installation, premiers conteneurs et images</p>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-warning me-2">5-10</span>
                                <strong>Intermédiaire</strong>
                            </div>
                            <p class="small text-muted">Docker Compose, réseaux, sécurité et distribution</p>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-danger me-2">11-18</span>
                                <strong>Avancé</strong>
                            </div>
                            <p class="small text-muted">Orchestration, CI/CD, monitoring et projets complets</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et tri -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h2 class="fw-bold mb-0">
                    <i class="fas fa-book-open me-2"></i>
                    Catalogue des modules
                </h2>
                <div class="d-flex gap-2 flex-wrap">
                    <select class="form-select" id="levelFilter" style="min-width: 150px;">
                        <option value="">Tous les niveaux</option>
                        <option value="débutant">Débutant (1-4)</option>
                        <option value="intermédiaire">Intermédiaire (5-10)</option>
                        <option value="avancé">Avancé (11-18)</option>
                    </select>
                    <select class="form-select" id="sortBy" style="min-width: 150px;">
                        <option value="order">Ordre pédagogique</option>
                        <option value="popular">Plus populaires</option>
                        <option value="duration_short">Durée croissante</option>
                        <option value="duration_long">Durée décroissante</option>
                        <option value="price_low">Prix croissant</option>
                        <option value="price_high">Prix décroissant</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Simulation des cours - Plan de formation Docker complet (18 modules)
    $courses = $courses ?? [
        // NIVEAU DÉBUTANT
        [
            'id' => 1,
            'title' => 'Module 1 : Introduction et concepts fondamentaux',
            'description' => 'Découvrez ce qu\'est Docker, pourquoi l\'utiliser, et les concepts de base : conteneurs vs machines virtuelles, images, registres.',
            'level' => 'débutant',
            'duration_hours' => 4,
            'price' => 29.99,
            'enrolled_count' => 342,
            'instructor_full_name' => 'Jean Dupont',
            'image_url' => null,
            'created_at' => '2024-01-01 10:00:00'
        ],
        [
            'id' => 2,
            'title' => 'Module 2 : Installation et premiers pas',
            'description' => 'Installation de Docker sur différents OS, configuration initiale, commandes de base et premier conteneur "Hello World".',
            'level' => 'débutant',
            'duration_hours' => 3,
            'price' => 24.99,
            'enrolled_count' => 298,
            'instructor_full_name' => 'Sophie Martin',
            'image_url' => null,
            'created_at' => '2024-01-05 14:30:00'
        ],
        [
            'id' => 3,
            'title' => 'Module 3 : Images Docker',
            'description' => 'Gestion des images : pull/push, création, optimisation, bonnes pratiques. Maîtrisez le système d\'images Docker.',
            'level' => 'débutant',
            'duration_hours' => 5,
            'price' => 34.99,
            'enrolled_count' => 267,
            'instructor_full_name' => 'Pierre Bernard',
            'image_url' => null,
            'created_at' => '2024-01-10 09:15:00'
        ],
        [
            'id' => 4,
            'title' => 'Module 4 : Conteneurs - Gestion avancée',
            'description' => 'Cycle de vie des conteneurs, volumes, ports, variables d\'environnement, logs et monitoring de base.',
            'level' => 'débutant',
            'duration_hours' => 6,
            'price' => 39.99,
            'enrolled_count' => 234,
            'instructor_full_name' => 'Marie Leroy',
            'image_url' => null,
            'created_at' => '2024-01-15 16:45:00'
        ],
        [
            'id' => 5,
            'title' => 'Module 5 : Dockerfile - Maîtrise complète',
            'description' => 'Syntaxe Dockerfile, instructions avancées, multi-stage builds, optimisation des layers et cache.',
            'level' => 'intermédiaire',
            'duration_hours' => 7,
            'price' => 44.99,
            'enrolled_count' => 189,
            'instructor_full_name' => 'Thomas Robert',
            'image_url' => null,
            'created_at' => '2024-01-20 11:20:00'
        ],

        // NIVEAU INTERMÉDIAIRE
        [
            'id' => 6,
            'title' => 'Module 6 : Docker Compose - Applications multi-conteneurs',
            'description' => 'Orchestration avec Docker Compose : services, réseaux, volumes, environnements et déploiement.',
            'level' => 'intermédiaire',
            'duration_hours' => 8,
            'price' => 54.99,
            'enrolled_count' => 156,
            'instructor_full_name' => 'Laurent Dubois',
            'image_url' => null,
            'created_at' => '2024-01-25 13:10:00'
        ],
        [
            'id' => 7,
            'title' => 'Module 7 : Réseaux Docker',
            'description' => 'Types de réseaux, communication inter-conteneurs, isolation, bridge, host, overlay et configuration avancée.',
            'level' => 'intermédiaire',
            'duration_hours' => 6,
            'price' => 49.99,
            'enrolled_count' => 134,
            'instructor_full_name' => 'Anne Moreau',
            'image_url' => null,
            'created_at' => '2024-02-01 15:30:00'
        ],
        [
            'id' => 8,
            'title' => 'Module 8 : Stockage et volumes',
            'description' => 'Persistance des données : volumes nommés, bind mounts, tmpfs, stratégies de sauvegarde et performance.',
            'level' => 'intermédiaire',
            'duration_hours' => 5,
            'price' => 42.99,
            'enrolled_count' => 145,
            'instructor_full_name' => 'Nicolas Petit',
            'image_url' => null,
            'created_at' => '2024-02-05 10:15:00'
        ],
        [
            'id' => 9,
            'title' => 'Module 9 : Sécurité Docker',
            'description' => 'Bonnes pratiques de sécurité : utilisateurs non-root, secrets, scanning d\'images, politiques de sécurité.',
            'level' => 'intermédiaire',
            'duration_hours' => 7,
            'price' => 59.99,
            'enrolled_count' => 98,
            'instructor_full_name' => 'Sylvie Roux',
            'image_url' => null,
            'created_at' => '2024-02-10 14:20:00'
        ],
        [
            'id' => 10,
            'title' => 'Module 10 : Docker Registry et distribution',
            'description' => 'Docker Hub, registres privés, Harbor, distribution d\'images, versionning et gestion des artifacts.',
            'level' => 'intermédiaire',
            'duration_hours' => 6,
            'price' => 47.99,
            'enrolled_count' => 112,
            'instructor_full_name' => 'Julien Blanc',
            'image_url' => null,
            'created_at' => '2024-02-15 09:45:00'
        ],

        // NIVEAU AVANCÉ
        [
            'id' => 11,
            'title' => 'Module 11 : Docker Swarm - Orchestration native',
            'description' => 'Clusters Docker Swarm, services, scaling, load balancing, rolling updates et haute disponibilité.',
            'level' => 'avancé',
            'duration_hours' => 10,
            'price' => 79.99,
            'enrolled_count' => 76,
            'instructor_full_name' => 'Frédéric Noir',
            'image_url' => null,
            'created_at' => '2024-02-20 12:30:00'
        ],
        [
            'id' => 12,
            'title' => 'Module 12 : Introduction à Kubernetes',
            'description' => 'Migration de Docker vers Kubernetes : pods, services, deployments, ingress et écosystème K8s.',
            'level' => 'avancé',
            'duration_hours' => 12,
            'price' => 89.99,
            'enrolled_count' => 67,
            'instructor_full_name' => 'Catherine Vert',
            'image_url' => null,
            'created_at' => '2024-02-25 16:00:00'
        ],
        [
            'id' => 13,
            'title' => 'Module 13 : CI/CD avec Docker',
            'description' => 'Intégration continue : Jenkins, GitLab CI, GitHub Actions, automatisation des builds et déploiements.',
            'level' => 'avancé',
            'duration_hours' => 9,
            'price' => 74.99,
            'enrolled_count' => 89,
            'instructor_full_name' => 'Vincent Jaune',
            'image_url' => null,
            'created_at' => '2024-03-01 11:15:00'
        ],
        [
            'id' => 14,
            'title' => 'Module 14 : Monitoring et observabilité',
            'description' => 'Supervision des conteneurs : Prometheus, Grafana, ELK Stack, tracing distribué et métriques.',
            'level' => 'avancé',
            'duration_hours' => 8,
            'price' => 69.99,
            'enrolled_count' => 54,
            'instructor_full_name' => 'Isabelle Rose',
            'image_url' => null,
            'created_at' => '2024-03-05 13:45:00'
        ],
        [
            'id' => 15,
            'title' => 'Module 15 : Performance et optimisation',
            'description' => 'Optimisation des images, ressources, cache, profiling, benchmarking et tuning des performances.',
            'level' => 'avancé',
            'duration_hours' => 7,
            'price' => 64.99,
            'enrolled_count' => 62,
            'instructor_full_name' => 'Olivier Bleu',
            'image_url' => null,
            'created_at' => '2024-03-10 10:30:00'
        ],

        // PROJETS PRATIQUES
        [
            'id' => 16,
            'title' => 'Module 16 : Projet - Application Web complète',
            'description' => 'Projet complet : application web avec base de données, reverse proxy, SSL, monitoring et déploiement.',
            'level' => 'avancé',
            'duration_hours' => 15,
            'price' => 99.99,
            'enrolled_count' => 43,
            'instructor_full_name' => 'Maxime Gris',
            'image_url' => null,
            'created_at' => '2024-03-15 14:20:00'
        ],
        [
            'id' => 17,
            'title' => 'Module 17 : Docker avec Symfony',
            'description' => 'Containerisation d\'applications Symfony : environnements dev/prod, tests, cache Redis, base de données.',
            'level' => 'avancé',
            'duration_hours' => 12,
            'price' => 84.99,
            'enrolled_count' => 38,
            'instructor_full_name' => 'Céline Violet',
            'image_url' => null,
            'created_at' => '2024-03-20 09:10:00'
        ],
        [
            'id' => 18,
            'title' => 'Module 18 : Docker avec Node.js et microservices',
            'description' => 'Architecture microservices avec Node.js : API Gateway, communication async, monitoring distribué.',
            'level' => 'avancé',
            'duration_hours' => 14,
            'price' => 94.99,
            'enrolled_count' => 31,
            'instructor_full_name' => 'Alexandre Orange',
            'image_url' => null,
            'created_at' => '2024-03-25 15:50:00'
        ]
    ];
    ?>

    <div class="row" id="coursesContainer">
        <?php foreach ($courses as $course): ?>
            <div class="col-lg-4 col-md-6 mb-4 course-item"
                data-level="<?= $course['level'] ?>"
                data-price="<?= $course['price'] ?>"
                data-popularity="<?= $course['enrolled_count'] ?>"
                data-duration="<?= $course['duration_hours'] ?>"
                data-order="<?= $course['id'] ?>"
                data-created="<?= strtotime($course['created_at']) ?>">
                <div class="card course-card h-100 <?= $course['level'] === 'débutant' ? 'border-info' : ($course['level'] === 'intermédiaire' ? 'border-warning' : 'border-danger') ?>">
                    <?php if ($course['image_url']): ?>
                        <img src="<?= htmlspecialchars($course['image_url']) ?>" class="card-img-top course-image" alt="<?= htmlspecialchars($course['title']) ?>">
                    <?php else: ?>
                        <div class="card-img-top course-image d-flex align-items-center justify-content-center position-relative" style="height: 200px; background: linear-gradient(135deg, 
                            <?= $course['level'] === 'débutant' ? '#17a2b8, #138496' : ($course['level'] === 'intermédiaire' ? '#ffc107, #e0a800' : '#dc3545, #c82333') ?>);">
                            <i class="fab fa-docker fa-4x text-white opacity-75"></i>
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-dark fs-6">Module <?= $course['id'] ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-<?= $course['level'] === 'débutant' ? 'info' : ($course['level'] === 'intermédiaire' ? 'warning' : 'danger') ?> course-level">
                                <?= ucfirst($course['level']) ?>
                            </span>
                            <div class="text-end">
                                <small class="text-muted d-block">
                                    <i class="fas fa-clock me-1"></i><?= $course['duration_hours'] ?>h
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-star me-1 text-warning"></i>
                                    <?= number_format(4.2 + ($course['enrolled_count'] / 1000), 1) ?>/5
                                </small>
                            </div>
                        </div>

                        <h5 class="card-title fw-bold"><?= htmlspecialchars($course['title']) ?></h5>
                        <p class="card-text text-muted small"><?= htmlspecialchars($course['description']) ?></p>

                        <?php if ($course['id'] <= 4): ?>
                            <div class="alert alert-info small mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Prérequis :</strong> Aucun - Idéal pour débuter
                            </div>
                        <?php elseif ($course['id'] <= 10): ?>
                            <div class="alert alert-warning small mb-3">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <strong>Prérequis :</strong> Modules 1-4 recommandés
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger small mb-3">
                                <i class="fas fa-fire me-1"></i>
                                <strong>Prérequis :</strong> Modules 1-10 obligatoires
                            </div>
                        <?php endif; ?>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-chalkboard-teacher me-1"></i>
                                    <?= htmlspecialchars($course['instructor_full_name']) ?>
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    <?= $course['enrolled_count'] ?> inscrits
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="course-price fw-bold text-success fs-5">
                                    <?= number_format($course['price'], 2, ',', ' ') ?> €
                                </span>
                                <div class="btn-group">
                                    <a href="<?= url('/cours/' . $course['id']) ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Détails
                                    </a>
                                    <?php if (is_logged_in()): ?>
                                        <form method="POST" action="<?= url('/cours/' . $course['id'] . '/enroll') ?>" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-play me-1"></i>Commencer
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="<?= url('/login') ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-sign-in-alt me-1"></i>Se connecter
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($courses)): ?>
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fab fa-docker fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Aucun module disponible</h3>
                    <p class="text-muted">Les modules de formation seront bientôt disponibles. Revenez plus tard !</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Section Projets Pratiques Spéciaux -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h3 class="mb-4">
                        <i class="fas fa-project-diagram me-2"></i>
                        Projets Pratiques Avancés
                    </h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <strong>16</strong>
                                </div>
                                <div>
                                    <h6 class="mb-1">Application Web Complète</h6>
                                    <small class="text-light opacity-75">Stack complète avec monitoring</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <strong>17</strong>
                                </div>
                                <div>
                                    <h6 class="mb-1">Docker + Symfony</h6>
                                    <small class="text-light opacity-75">Framework PHP moderne</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <strong>18</strong>
                                </div>
                                <div>
                                    <h6 class="mb-1">Node.js & Microservices</h6>
                                    <small class="text-light opacity-75">Architecture distribuée</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <p class="mb-3">Ces modules avancés nécessitent la validation des modules 1-15</p>
                        <a href="<?= url('/about') ?>" class="btn btn-light">
                            <i class="fas fa-info-circle me-2"></i>
                            En savoir plus sur le parcours
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-5">
                    <h2 class="mb-3">Commencez votre parcours Docker dès maintenant !</h2>
                    <p class="lead mb-4">
                        Rejoignez plus de <strong>1200 développeurs</strong> qui maîtrisent déjà Docker grâce à notre formation progressive en 18 modules.
                    </p>

                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="h-100">
                                        <i class="fas fa-certificate fa-2x mb-2"></i>
                                        <h6>Certification</h6>
                                        <small>Obtenez votre certificat de maîtrise Docker</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="h-100">
                                        <i class="fas fa-hands-helping fa-2x mb-2"></i>
                                        <h6>Support</h6>
                                        <small>Accompagnement personnalisé tout au long du parcours</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="h-100">
                                        <i class="fas fa-infinity fa-2x mb-2"></i>
                                        <h6>Accès illimité</h6>
                                        <small>Contenus mis à jour et accès à vie</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!is_logged_in()): ?>
                        <a href="<?= url('/register') ?>" class="btn btn-light btn-lg me-3">
                            <i class="fas fa-rocket me-2"></i>
                            Commencer gratuitement
                        </a>
                        <a href="<?= url('/about') ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-map me-2"></i>
                            Voir le programme complet
                        </a>
                    <?php else: ?>
                        <a href="<?= url('/cours/1') ?>" class="btn btn-light btn-lg me-3">
                            <i class="fas fa-play me-2"></i>
                            Commencer le Module 1
                        </a>
                        <a href="<?= url('/dashboard') ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Mon tableau de bord
                        </a>
                    <?php endif; ?>

                    <div class="mt-4">
                        <small class="opacity-75">
                            💡 Conseil : Commencez par le Module 1 même si vous avez des bases Docker
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const levelFilter = document.getElementById('levelFilter');
        const sortBy = document.getElementById('sortBy');
        const coursesContainer = document.getElementById('coursesContainer');
        let courses = Array.from(coursesContainer.querySelectorAll('.course-item'));

        function filterAndSortCourses() {
            const selectedLevel = levelFilter.value;
            const selectedSort = sortBy.value;

            // Réinitialiser l'affichage de tous les cours
            courses.forEach(course => {
                course.style.display = 'block';
            });

            // Filtrer par niveau
            const visibleCourses = courses.filter(course => {
                const courseLevel = course.dataset.level;
                const shouldShow = !selectedLevel || courseLevel === selectedLevel;

                if (!shouldShow) {
                    course.style.display = 'none';
                }

                return shouldShow;
            });

            // Trier les cours visibles
            visibleCourses.sort((a, b) => {
                switch (selectedSort) {
                    case 'popular':
                        return parseInt(b.dataset.popularity) - parseInt(a.dataset.popularity);
                    case 'duration_short':
                        return parseInt(a.dataset.duration) - parseInt(b.dataset.duration);
                    case 'duration_long':
                        return parseInt(b.dataset.duration) - parseInt(a.dataset.duration);
                    case 'price_low':
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    case 'price_high':
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    case 'order':
                    default:
                        return parseInt(a.dataset.order) - parseInt(b.dataset.order);
                }
            });

            // Réorganiser les éléments dans le DOM
            visibleCourses.forEach(course => {
                coursesContainer.appendChild(course);
            });

            // Ajouter une animation pour les changements
            coursesContainer.style.opacity = '0.7';
            setTimeout(() => {
                coursesContainer.style.opacity = '1';
            }, 150);
        }

        // Gestionnaires d'événements
        levelFilter.addEventListener('change', filterAndSortCourses);
        sortBy.addEventListener('change', filterAndSortCourses);

        // Effet de survol amélioré
        courses.forEach(courseItem => {
            const card = courseItem.querySelector('.card');

            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 25px rgba(0,123,255,0.15)';
                this.style.transition = 'all 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            });
        });

        // Indicateur de progression pour les modules
        function updateProgressIndicators() {
            courses.forEach((courseItem, index) => {
                const moduleNumber = parseInt(courseItem.dataset.order);
                const card = courseItem.querySelector('.card');

                // Ajouter un indicateur de progression visuel
                if (moduleNumber <= 4) {
                    card.classList.add('border-info');
                } else if (moduleNumber <= 10) {
                    card.classList.add('border-warning');
                } else {
                    card.classList.add('border-danger');
                }
            });
        }

        // Initialiser les indicateurs
        updateProgressIndicators();
    });
</script>