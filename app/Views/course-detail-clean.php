<div class="container py-5">
    <?php
    $isEnrolled = false; // Vérifier si l'utilisateur est inscrit
    ?>

    <div class="row">
        <!-- Contenu principal du cours -->
        <div class="col-lg-8">
            <!-- En-tête du cours -->
            <div class="card card-custom mb-4">
                <?php if ($course['image_url']): ?>
                    <img src="<?= htmlspecialchars($course['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 300px; object-fit: cover;">
                <?php else: ?>
                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" style="height: 300px; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                        <i class="fab fa-docker fa-5x text-white opacity-75"></i>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-<?= $course['level'] === 'débutant' ? 'info' : ($course['level'] === 'intermédiaire' ? 'warning' : 'danger') ?> mb-2">
                                <?= ucfirst($course['level']) ?>
                            </span>
                            <h1 class="h2 mb-2"><?= htmlspecialchars($course['title']) ?></h1>
                            <p class="lead text-muted"><?= htmlspecialchars($course['description']) ?></p>
                        </div>
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-md-3">
                            <div class="border-end">
                                <div class="h4 text-primary mb-0">
                                    <i class="fas fa-clock me-1"></i>
                                    <?= $course['duration_hours'] ?>h
                                </div>
                                <small class="text-muted">Durée totale</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <div class="h4 text-success mb-0">
                                    <i class="fas fa-users me-1"></i>
                                    <?= $course['enrolled_count'] ?? 0 ?>
                                </div>
                                <small class="text-muted">Étudiants</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <div class="h4 text-warning mb-0">
                                    <i class="fas fa-list me-1"></i>
                                    <?= isset($moduleContent['chapters']) ? count($moduleContent['chapters']) : 5 ?>
                                </div>
                                <small class="text-muted">Chapitres</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="h4 text-info mb-0">
                                <i class="fas fa-certificate me-1"></i>
                                Oui
                            </div>
                            <small class="text-muted">Certificat</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu du cours -->
            <div class="card card-custom mb-4">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        À propos de ce cours
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (isset($moduleContent['readme']) && $moduleContent['readme']): ?>
                        <!-- Contenu du README -->
                        <div class="module-content">
                            <?php
                            // Chercher les objectifs pédagogiques dans les chapitres
                            $objectivesFound = false;
                            if (isset($moduleContent['chapters'])) {
                                foreach ($moduleContent['chapters'] as $chapter) {
                                    if (strpos($chapter['title'], 'Objectifs pédagogiques') !== false) {
                                        echo "<h4>Objectifs pédagogiques</h4>";
                                        echo "<div class='objectives'>" . nl2br(htmlspecialchars($chapter['content'])) . "</div>";
                                        $objectivesFound = true;
                                        break;
                                    }
                                }
                            }
                            ?>
                        </div>
                    <?php else: ?>
                        <!-- Contenu par défaut -->
                        <h4>Ce que vous allez apprendre</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Les concepts fondamentaux de Docker et de la conteneurisation</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Comment créer et gérer des conteneurs Docker</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Utilisation de Docker Compose pour les applications multi-conteneurs</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Déploiement d'applications PHP et web avec Docker</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Bonnes pratiques de sécurité et d'optimisation</li>
                        </ul>

                        <h4 class="mt-4">Prérequis</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Connaissances de base en ligne de commande</li>
                            <li class="mb-2"><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Notions de développement web (HTML, CSS, PHP)</li>
                            <li class="mb-2"><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Aucune expérience Docker requise</li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Chapitres du cours -->
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Contenu du cours
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="chaptersAccordion">
                        <?php
                        // Utiliser les chapitres du module si disponibles, sinon utiliser les chapitres statiques
                        $chaptersToShow = isset($moduleContent['chapters']) && !empty($moduleContent['chapters'])
                            ? $moduleContent['chapters']
                            : [
                                ['id' => 1, 'title' => '🧱 Introduction à Docker', 'description' => 'Qu\'est-ce que Docker ? Pourquoi l\'utiliser ?', 'duration' => '45 min'],
                                ['id' => 2, 'title' => '🧰 Commandes de base Docker', 'description' => 'Maîtrisez les commandes essentielles', 'duration' => '60 min'],
                                ['id' => 3, 'title' => '🌍 Projet statique avec NGINX', 'description' => 'Serveur web avec Docker', 'duration' => '75 min'],
                                ['id' => 4, 'title' => '🐘 PHP Vanilla avec Docker', 'description' => 'Développement PHP containerisé', 'duration' => '90 min'],
                                ['id' => 5, 'title' => '🛢️ MySQL + PHP via docker-compose', 'description' => 'Base de données et orchestration', 'duration' => '120 min']
                            ];

                        foreach ($chaptersToShow as $index => $chapter):
                            $chapterId = $chapter['id'] ?? $index; ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="chapter<?= $chapterId ?>">
                                    <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $chapterId ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <div>
                                                <strong><?= htmlspecialchars($chapter['title']) ?></strong>
                                                <div class="text-muted small"><?= htmlspecialchars($chapter['description'] ?? '') ?></div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-secondary"><?= $chapter['duration'] ?? '45 min' ?></span>
                                                <?php if ($chapter['completed'] ?? false): ?>
                                                    <i class="fas fa-check-circle text-success ms-2"></i>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse<?= $chapterId ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#chaptersAccordion">
                                    <div class="accordion-body">
                                        <?php if (isset($chapter['content']) && !empty($chapter['content'])): ?>
                                            <!-- Contenu réel du chapitre -->
                                            <div class="chapter-content">
                                                <?= nl2br(htmlspecialchars(substr($chapter['content'], 0, 500))) ?>
                                                <?php if (strlen($chapter['content']) > 500): ?>
                                                    <span class="text-muted">... (contenu complet disponible dans le cours)</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">Contenu du chapitre à venir...</p>
                                        <?php endif; ?>

                                        <?php if ($isEnrolled): ?>
                                            <div class="mt-3">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fas fa-play me-1"></i>
                                                    Commencer ce chapitre
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Formation gratuite et inscription -->
            <div class="card card-custom mb-4 position-sticky" style="top: 20px;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="h2 text-success fw-bold">
                            <i class="fas fa-heart me-2"></i>FORMATION GRATUITE
                        </span>
                    </div>

                    <?php if ($isEnrolled): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Vous êtes inscrit à ce cours
                        </div>
                        <a href="#" class="btn btn-primary w-100 btn-lg mb-3">
                            <i class="fas fa-play me-2"></i>
                            Continuer le cours
                        </a>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                        <small class="text-muted">Progression : 25% terminé</small>
                    <?php else: ?>
                        <?php if (is_logged_in()): ?>
                            <form method="POST" action="<?= url('/cours/' . $course['id'] . '/enroll') ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                                    <i class="fas fa-play me-2"></i>
                                    S'inscrire gratuitement
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="<?= url('/register') ?>" class="btn btn-primary w-100 btn-lg mb-3">
                                <i class="fas fa-user-plus me-2"></i>
                                Créer un compte pour commencer
                            </a>
                        <?php endif; ?>
                        <p class="text-muted mb-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Formation 100% gratuite et accessible à vie
                        </p>
                    <?php endif; ?>

                    <div class="row text-center">
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#shareModal">
                                <i class="fas fa-share me-1"></i>
                                Partager
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="fas fa-heart me-1"></i>
                                Favoris
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructeur -->
            <div class="card card-custom mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tie me-2"></i>
                        Votre instructeur
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0"><?= htmlspecialchars($course['instructor_full_name'] ?? 'Formation Docker') ?></h6>
                            <small class="text-muted">Expert Docker & DevOps</small>
                        </div>
                    </div>
                    <p class="text-muted small">
                        Développeur Senior avec plus de 10 ans d'expérience dans le domaine DevOps et la conteneurisation.
                    </p>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="fw-bold">25+</div>
                            <small class="text-muted">Cours</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold">5000+</div>
                            <small class="text-muted">Étudiants</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold">4.8★</div>
                            <small class="text-muted">Note</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ce cours inclut -->
            <div class="card card-custom">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-gift me-2"></i>
                        Ce cours inclut
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-video text-primary me-2"></i>
                            <?= $course['duration_hours'] ?>h de contenu
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-file-code text-primary me-2"></i>
                            Fichiers sources et exercices
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-mobile-alt text-primary me-2"></i>
                            Accès mobile et TV
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-infinity text-primary me-2"></i>
                            Accès à vie
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-certificate text-primary me-2"></i>
                            Certificat de fin de formation
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-comments text-primary me-2"></i>
                            Support Q&A
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>