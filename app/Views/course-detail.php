<div class="container py-5">
    <div class="row">
        <!-- Contenu principal du cours -->
        <div class="col-lg-8">
            <!-- En-tête du cours -->
            <div class="card card-custom mb-4">
                <?php if ($course['image_url']): ?>
                    <img src="<?= htmlspecialchars($course['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 300px; object-fit: cover;">
                <?php else: ?> <?php
                                // Définir les classes CSS pour les dégradés en fonction de l'ID du module
                                $gradientClass = '';
                                $moduleId = $course['id'];

                                if ($moduleId >= 1 && $moduleId <= 4) {
                                    $gradientClass = 'module-gradient-beginner';
                                } elseif ($moduleId >= 5 && $moduleId <= 10) {
                                    $gradientClass = 'module-gradient-intermediate';
                                } else {
                                    $gradientClass = 'module-gradient-advanced';
                                }
                                ?>
                    <div class="card-img-top <?= $gradientClass ?> d-flex align-items-center justify-content-center" style="height: 300px;">
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
                    <!-- Contenu simple et statique -->
                    <?php if ($course['id'] == 1): ?>
                        <h4>Ce que vous allez apprendre</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Comprendre ce qu'est Docker et la conteneurisation</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Différencier conteneurs et machines virtuelles</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Installer Docker sur votre système</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Créer et gérer vos premiers conteneurs</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Utiliser les commandes Docker essentielles</li>
                        </ul>

                        <h4 class="mt-4">Prérequis</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Connaissances de base en ligne de commande</li>
                            <li class="mb-2"><i class="fas fa-circle text-muted me-2" style="font-size: 0.5rem;"></i>Aucune expérience Docker requise</li>
                        </ul>
                    <?php else: ?>
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
                        // Chapitres statiques classiques selon le cours
                        if ($course['id'] == 1) {
                            $chapters = [
                                ['id' => 1, 'title' => '🧱 Introduction à Docker', 'description' => 'Qu\'est-ce que Docker ? Pourquoi l\'utiliser ?', 'duration' => '45 min', 'content' => 'Découvrez Docker et ses avantages par rapport aux approches traditionnelles.'],
                                ['id' => 2, 'title' => '📊 Conteneurs vs Machines Virtuelles', 'description' => 'Comprenez la différence fondamentale', 'duration' => '30 min', 'content' => 'Comparaison détaillée entre conteneurs et machines virtuelles.'],
                                ['id' => 3, 'title' => '🧰 Concepts fondamentaux', 'description' => 'Images, conteneurs, registres', 'duration' => '60 min', 'content' => 'Maîtrisez les concepts clés de l\'écosystème Docker.'],
                                ['id' => 4, 'title' => '� Installation de Docker', 'description' => 'Installez Docker sur votre système', 'duration' => '45 min', 'content' => 'Guide d\'installation pas à pas pour Windows, Mac et Linux.'],
                                ['id' => 5, 'title' => '� Premier conteneur Hello World', 'description' => 'Votre premier conteneur en action', 'duration' => '30 min', 'content' => 'Créez et exécutez votre premier conteneur Docker.']
                            ];
                        } else {
                            // Chapitres par défaut pour les autres cours
                            $chapters = [
                                ['id' => 1, 'title' => '🧱 Introduction', 'description' => 'Découvrez les bases', 'duration' => '45 min', 'content' => 'Introduction aux concepts de base.'],
                                ['id' => 2, 'title' => '🧰 Pratique', 'description' => 'Exercices pratiques', 'duration' => '60 min', 'content' => 'Mettez en pratique vos connaissances.'],
                                ['id' => 3, 'title' => '🚀 Projet final', 'description' => 'Réalisez un projet complet', 'duration' => '90 min', 'content' => 'Projet complet pour valider vos acquis.']
                            ];
                        }

                        foreach ($chapters as $index => $chapter): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="chapter<?= $chapter['id'] ?>">
                                    <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $chapter['id'] ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">>
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <div>
                                                <strong><?= htmlspecialchars($chapter['title']) ?></strong>
                                                <div class="chapter-description"><?= htmlspecialchars($chapter['description']) ?></div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-secondary"><?= $chapter['duration'] ?></span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse<?= $chapter['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#chaptersAccordion">
                                    <div class="accordion-body">
                                        <p><?= htmlspecialchars($chapter['content']) ?></p>

                                        <?php if ($isEnrolled): ?>
                                            <div class="mt-3">
                                                <a href="/cours/<?= $course['id'] ?>/chapitre/<?= $chapter['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-play me-1"></i>
                                                    Commencer ce chapitre
                                                </a>
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
            <div class="card card-custom mb-4">
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
                        <?php if (Session::get('user_id')): ?>
                            <form method="POST" action="/cours/<?= $course['id'] ?>/enroll">
                                <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                                    <i class="fas fa-play me-2"></i>
                                    S'inscrire gratuitement
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="/register" class="btn btn-primary w-100 btn-lg mb-3">
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