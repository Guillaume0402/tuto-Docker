<?php

/**
 * Fonction helper pour calculer le temps écoulé
 */
function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) return 'Il y a quelques secondes';
    if ($time < 3600) return 'Il y a ' . floor($time / 60) . ' min';
    if ($time < 86400) return 'Il y a ' . floor($time / 3600) . ' h';
    if ($time < 2592000) return 'Il y a ' . floor($time / 86400) . ' j';
    if ($time < 31536000) return 'Il y a ' . floor($time / 2592000) . ' mois';
    return 'Il y a ' . floor($time / 31536000) . ' an' . (floor($time / 31536000) > 1 ? 's' : '');
}
?>

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
                            <h4 class="mb-0"><?= $stats['total_enrolled'] ?? 0 ?></h4>
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
                            <h4 class="mb-0"><?= $stats['completed_courses'] ?? 0 ?></h4>
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
                            <h4 class="mb-0"><?= $stats['in_progress_courses'] ?? 0 ?></h4>
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
                            <h4 class="mb-0"><?= $stats['total_hours'] ?? 0 ?>h</h4>
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
                    // Filtrer les cours en cours (progression > 0 et < 100)
                    $activeCourses = array_filter($userCourses ?? [], function ($course) {
                        return $course['progress'] > 0 && $course['progress'] < 100;
                    });
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
                                            <i class="fas fa-clock me-1"></i>
                                            <?= $course['duration_hours'] ?? 0 ?> heures
                                            • Inscrit le <?= date('d/m/Y', strtotime($course['enrolled_at'])) ?>
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
                    <?php if (empty($userCourses)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune activité récente</p>
                            <a href="<?= url('/cours') ?>" class="btn btn-outline-primary btn-sm">
                                Commencer votre apprentissage
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php
                            // Trier les cours par date d'inscription (plus récent d'abord)
                            usort($userCourses, function ($a, $b) {
                                return strtotime($b['enrolled_at']) - strtotime($a['enrolled_at']);
                            });

                            foreach (array_slice($userCourses, 0, 4) as $course):
                                $timeAgo = timeAgo($course['enrolled_at']);
                            ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php if ($course['progress'] == 100): ?>
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <strong>Cours terminé:</strong> <?= htmlspecialchars($course['title']) ?>
                                        <?php elseif ($course['progress'] > 0): ?>
                                            <i class="fas fa-play text-primary me-2"></i>
                                            <strong>En cours:</strong> <?= htmlspecialchars($course['title']) ?> (<?= $course['progress'] ?>%)
                                        <?php else: ?>
                                            <i class="fas fa-user-plus text-info me-2"></i>
                                            <strong>Inscription:</strong> <?= htmlspecialchars($course['title']) ?>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted">
                                            Niveau <?= $course['level'] ?> • <?= $course['duration_hours'] ?>h
                                        </small>
                                    </div>
                                    <small class="text-muted"><?= $timeAgo ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>