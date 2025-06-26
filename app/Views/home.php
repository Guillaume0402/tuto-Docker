<div class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <div class="mb-3 fade-in">
                    <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">
                        <i class="fas fa-heart me-2"></i>Formation 100% gratuite
                    </span>
                </div>
                <h1 class="display-4 fw-bold mb-4 fade-in">
                    Apprenez Docker facilement
                </h1>
                <p class="lead mb-4 fade-in">
                    Découvrez la conteneurisation avec nos tutoriels pratiques et interactifs.
                    De l'installation aux déploiements avancés, maîtrisez Docker pas à pas.
                </p>
                <div class="d-flex gap-3 fade-in">
                    <a href="<?= url('/cours') ?>" class="btn btn-light btn-lg btn-custom">
                        <i class="fas fa-play me-2"></i>Commencer maintenant
                    </a>
                    <a href="<?= url('/about') ?>" class="btn btn-outline-light btn-lg btn-custom">
                        <i class="fas fa-info-circle me-2"></i>En savoir plus
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <img src="<?= asset('img/logo.svg') ?>" alt="Docker Logo" class="img-fluid" style="max-width: 300px; opacity: 0.8;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <i class="fab fa-docker display-1 text-white opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Section des fonctionnalités -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">Pourquoi choisir nos tutoriels ?</h2>
            <p class="lead text-muted">Une approche pratique et progressive pour maîtriser Docker</p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-custom text-center h-100" data-animate>
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-rocket fa-3x text-primary"></i>
                    </div>
                    <h4>Rapide à apprendre</h4>
                    <p class="card-text">
                        Des concepts expliqués simplement avec des exemples concrets et pratiques.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-custom text-center h-100" data-animate>
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-hands-helping fa-3x text-success"></i>
                    </div>
                    <h4>Support inclus</h4>
                    <p class="card-text">
                        Une communauté active et un support technique pour vous accompagner.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-custom text-center h-100" data-animate>
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-trophy fa-3x text-warning"></i>
                    </div>
                    <h4>Projets réels</h4>
                    <p class="card-text">
                        Travaillez sur des projets concrets et construisez votre portfolio.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des cours populaires -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">Cours populaires</h2>
            <p class="lead text-muted">Commencez par ces cours recommandés</p>
        </div>

        <?php
        // Cours populaires de la formation Docker complète - GRATUITS
        $featuredCourses = [
            [
                'id' => 1,
                'title' => 'Module 1 : Introduction et concepts fondamentaux',
                'description' => 'Découvrez ce qu\'est Docker, pourquoi l\'utiliser, et les concepts de base',
                'level' => 'débutant',
                'duration_hours' => 4,
                'enrolled_count' => 342
            ],
            [
                'id' => 6,
                'title' => 'Module 6 : Docker Compose - Applications multi-conteneurs',
                'description' => 'Orchestration avec Docker Compose : services, réseaux, volumes',
                'level' => 'intermédiaire',
                'duration_hours' => 8,
                'enrolled_count' => 156
            ],
            [
                'id' => 16,
                'title' => 'Module 16 : Projet - Application Web complète',
                'description' => 'Projet complet avec base de données, reverse proxy, SSL et monitoring',
                'level' => 'avancé',
                'duration_hours' => 15,
                'enrolled_count' => 43
            ]
        ];
        ?>

        <?php foreach ($featuredCourses as $course): ?>
            <div class="col-lg-4 mb-4">
                <div class="card course-card h-100" data-animate>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-<?= $course['level'] === 'débutant' ? 'info' : ($course['level'] === 'intermédiaire' ? 'warning' : 'danger') ?>">
                                <?= ucfirst($course['level']) ?>
                            </span>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i><?= $course['duration_hours'] ?>h
                            </small>
                        </div>

                        <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-heart me-1"></i>GRATUIT
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i><?= $course['enrolled_count'] ?> inscrits
                                </small>
                            </div>

                            <a href="<?= url('/cours/' . $course['id']) ?>" class="btn btn-primary w-100 btn-custom">
                                Commencer maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="col-12 text-center mt-4">
            <a href="<?= url('/cours') ?>" class="btn btn-outline-primary btn-lg btn-custom">
                Voir tous les cours
            </a>
        </div>
    </div>

    <?php
    // Récupération des statistiques réelles depuis la base de données
    $statistics = new Statistics();
    $stats = $statistics->getHomeStatistics();
    ?>

    <!-- Section statistiques -->
    <div class="row text-center py-5 bg-light rounded">
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-primary">
                <?= $statistics->formatStudentCount($stats['totalStudents']) ?>
            </div>
            <div class="text-muted"><?= $statistics->formatStudentLabel($stats['totalStudents']) ?></div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-success"><?= $stats['totalCourses'] ?></div>
            <div class="text-muted">Modules progressifs</div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-warning"><?= $stats['totalHours'] ?>+</div>
            <div class="text-muted">Heures de formation</div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-info"><?= $stats['totalProjects'] ?></div>
            <div class="text-muted">Projets complets</div>
        </div>
    </div>
</div>