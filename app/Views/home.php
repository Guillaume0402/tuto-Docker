<div class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
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
        // Simuler quelques cours pour la démonstration
        $featuredCourses = [
            [
                'id' => 1,
                'title' => 'Introduction à Docker',
                'description' => 'Découvrez les bases de Docker et de la conteneurisation',
                'level' => 'débutant',
                'duration_hours' => 8,
                'price' => 49.99,
                'enrolled_count' => 156
            ],
            [
                'id' => 2,
                'title' => 'Docker Compose avancé',
                'description' => 'Orchestrez vos applications multi-conteneurs',
                'level' => 'intermédiaire',
                'duration_hours' => 12,
                'price' => 79.99,
                'enrolled_count' => 89
            ],
            [
                'id' => 3,
                'title' => 'Déploiement en production',
                'description' => 'Déployez vos applications Docker en production',
                'level' => 'avancé',
                'duration_hours' => 16,
                'price' => 99.99,
                'enrolled_count' => 67
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
                                <span class="course-price"><?= number_format($course['price'], 2, ',', ' ') ?> €</span>
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i><?= $course['enrolled_count'] ?> inscrits
                                </small>
                            </div>

                            <a href="<?= url('/cours/' . $course['id']) ?>" class="btn btn-primary w-100 btn-custom">
                                Voir le cours
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

    <!-- Section statistiques -->
    <div class="row text-center py-5 bg-light rounded">
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-primary">500+</div>
            <div class="text-muted">Étudiants actifs</div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-success">25+</div>
            <div class="text-muted">Cours disponibles</div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-warning">95%</div>
            <div class="text-muted">Taux de satisfaction</div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="display-4 fw-bold text-info">24/7</div>
            <div class="text-muted">Support disponible</div>
        </div>
    </div>
</div>