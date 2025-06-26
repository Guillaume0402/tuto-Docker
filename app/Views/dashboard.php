<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </h1>
                <span class="badge bg-success fs-6">
                    Connecté en tant que <?= htmlspecialchars($user['username']) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card card-custom bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">5</h4>
                            <small>Cours suivis</small>
                        </div>
                        <i class="fas fa-book-open fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-custom bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">3</h4>
                            <small>Cours terminés</small>
                        </div>
                        <i class="fas fa-trophy fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-custom bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">2</h4>
                            <small>En cours</small>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-custom bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">24h</h4>
                            <small>Temps total</small>
                        </div>
                        <i class="fas fa-user-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profil utilisateur -->
        <div class="col-lg-4 mb-4">
            <div class="card card-custom">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Mon Profil
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    </div>

                    <h5 class="mb-1">
                        <?= htmlspecialchars(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))) ?: $user['username'] ?>
                    </h5>
                    <p class="text-muted mb-2"><?= htmlspecialchars($user['email']) ?></p>
                    <small class="text-muted">
                        Membre depuis <?= date('F Y', strtotime($user['created_at'])) ?>
                    </small>

                    <hr>

                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            Modifier le profil
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-key me-1"></i>
                            Changer le mot de passe
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cours en cours -->
        <div class="col-lg-8 mb-4">
            <div class="card card-custom">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-play-circle me-2"></i>
                        Mes Cours en Cours
                    </h5>
                    <a href="<?= url('/cours') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Nouveau cours
                    </a>
                </div>
                <div class="card-body">
                    <?php
                    // Simulation de cours en cours
                    $activeCourses = [
                        [
                            'id' => 1,
                            'title' => 'Introduction à Docker',
                            'progress' => 75,
                            'next_lesson' => 'Chapitre 4: Docker Compose',
                            'level' => 'débutant'
                        ],
                        [
                            'id' => 2,
                            'title' => 'PHP avec Docker',
                            'progress' => 45,
                            'next_lesson' => 'Chapitre 2: Configuration Apache',
                            'level' => 'intermédiaire'
                        ]
                    ];
                    ?>

                    <?php if (empty($activeCourses)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Aucun cours en cours</h6>
                            <p class="text-muted mb-3">Commencez votre apprentissage dès maintenant</p>
                            <a href="<?= url('/cours') ?>" class="btn btn-primary">
                                Parcourir les cours
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($activeCourses as $course): ?>
                            <div class="border rounded p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1"><?= htmlspecialchars($course['title']) ?></h6>
                                        <p class="text-muted mb-2 small">
                                            Prochaine leçon: <?= htmlspecialchars($course['next_lesson']) ?>
                                        </p>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $course['progress'] ?>%"></div>
                                        </div>
                                        <small class="text-muted"><?= $course['progress'] ?>% terminé</small>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <span class="badge bg-<?= $course['level'] === 'débutant' ? 'info' : ($course['level'] === 'intermédiaire' ? 'warning' : 'danger') ?> mb-2">
                                            <?= ucfirst($course['level']) ?>
                                        </span>
                                        <br>
                                        <a href="<?= url('/cours/' . $course['id']) ?>" class="btn btn-outline-primary btn-sm">
                                            Continuer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Activité récente -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Activité Récente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <strong>Cours terminé:</strong> Introduction à Docker - Chapitre 3
                            </div>
                            <small class="text-muted">Il y a 2 heures</small>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-play text-primary me-2"></i>
                                <strong>Leçon commencée:</strong> PHP avec Docker - Configuration
                            </div>
                            <small class="text-muted">Hier</small>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-certificate text-warning me-2"></i>
                                <strong>Badge obtenu:</strong> Premiers pas avec Docker
                            </div>
                            <small class="text-muted">Il y a 3 jours</small>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-plus text-info me-2"></i>
                                <strong>Inscription:</strong> Docker en production
                            </div>
                            <small class="text-muted">Il y a 1 semaine</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>