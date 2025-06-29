<?php
// Plus besoin de fonction Markdown compliquée - le contenu est déjà en HTML simple
?>

<!-- CSS spécifique pour les chapitres -->
<link rel="stylesheet" href="/assets/css/chapter.css">

<!-- Indicateur de progression de lecture -->
<div class="progress-indicator">
    <div class="progress-bar" id="readingProgress"></div>
</div>

<div class="chapter-page">
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-xl-3 col-lg-4">
                <div class="chapter-navigation sticky-top" style="top: 2rem;">
                    <div class="card-header border-0 bg-transparent">
                        <div class="d-flex align-items-center">
                            <a href="/cours/<?= $courseId ?>" class="btn btn-outline-primary btn-sm me-3">
                                <i class="fas fa-arrow-left me-1"></i>
                                Retour
                            </a>
                            <div>
                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($course['title']) ?></h6>
                                <small class="text-muted">Chapitre <?= $chapterNumber ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-info px-3 py-2"><?= $chapter['duration'] ?></span>
                            <span class="badge bg-<?= $chapter['type'] === 'theory' ? 'primary' : 'success' ?> px-3 py-2">
                                <?= $chapter['type'] === 'theory' ? 'Théorie' : 'Pratique' ?>
                            </span>
                        </div>

                        <!-- Progression -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted fw-medium">Progression du cours</small>
                                <small class="text-muted fw-bold" id="progressPercentage"><?= $currentProgress ?>%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-gradient-success" id="progressBar" style="width: <?= $currentProgress ?>%"></div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <?= $completedChapters ?> sur <?= $totalChapters ?> chapitres terminés
                            </small>
                        </div>

                        <!-- Navigation entre chapitres -->
                        <div class="d-grid gap-3">
                            <?php if ($chapterNumber > 1): ?>
                                <a href="/cours/<?= $courseId ?>/chapitre/<?= $chapterNumber - 1 ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-chevron-left me-2"></i>
                                    Chapitre précédent
                                </a>
                            <?php endif; ?>

                            <?php if ($chapterNumber < 5): ?>
                                <a href="/cours/<?= $courseId ?>/chapitre/<?= $chapterNumber + 1 ?>" class="btn btn-primary">
                                    Chapitre suivant
                                    <i class="fas fa-chevron-right ms-2"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-xl-9 col-lg-8">
                <div class="chapter-content-card">
                    <div class="card-header bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h1 class="display-6 fw-bold mb-0"><?= htmlspecialchars($chapter['title']) ?></h1>
                            </div>
                            <div class="btn-group ms-3">
                                <button class="btn btn-outline-secondary" id="toggleNotes" title="Prendre des notes">
                                    <i class="fas fa-sticky-note"></i>
                                </button>
                                <button class="btn btn-outline-secondary" id="toggleBookmark" title="Marquer cette page">
                                    <i class="far fa-bookmark"></i>
                                </button>
                                <button class="btn btn-outline-secondary" id="toggleFullscreen" title="Mode plein écran">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        <!-- Contenu du chapitre -->
                        <div class="chapter-content">
                            <?= $chapter['content'] ?>
                        </div>

                        <!-- Section Notes (masquée par défaut) -->
                        <div id="notesSection" class="notes-section" style="display: none;">
                            <h5 class="mb-3">
                                <i class="fas fa-sticky-note me-2"></i>
                                Mes Notes Personnelles
                            </h5>
                            <textarea class="form-control" rows="6" placeholder="Ajoutez vos notes, réflexions ou questions sur ce chapitre..."></textarea>
                            <div class="mt-3">
                                <button class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Sauvegarder mes notes
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation en bas -->
                    <div class="chapter-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <?php if ($chapterNumber > 1): ?>
                                    <a href="/cours/<?= $courseId ?>/chapitre/<?= $chapterNumber - 1 ?>" class="btn btn-light">
                                        <i class="fas fa-chevron-left me-2"></i>
                                        Précédent
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="text-center">
                                <button class="btn btn-success btn-lg" id="markComplete">
                                    <i class="fas fa-check me-2"></i>
                                    Marquer comme terminé
                                </button>
                            </div>

                            <div>
                                <?php if ($chapterNumber < 5): ?>
                                    <a href="/cours/<?= $courseId ?>/chapitre/<?= $chapterNumber + 1 ?>" class="btn btn-light">
                                        Suivant
                                        <i class="fas fa-chevron-right ms-2"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="/cours/<?= $courseId ?>" class="btn btn-outline-light">
                                        <i class="fas fa-list me-2"></i>
                                        Retour au cours
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles simples et clairs */
    .chapter-content h2 {
        color: #2c3e50;
        border-bottom: 3px solid #3498db;
        padding-bottom: 10px;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .chapter-content h3 {
        color: #34495e;
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .chapter-content p {
        line-height: 1.6;
        margin-bottom: 15px;
        color: #555;
    }

    .chapter-content ul,
    .chapter-content ol {
        margin: 15px 0;
        padding-left: 30px;
    }

    .chapter-content li {
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .chapter-content code {
        background: #f8f9fa;
        color: #e74c3c;
        padding: 3px 6px;
        border-radius: 4px;
        font-family: monospace;
    }

    .chapter-content .bg-dark {
        background-color: #2c3e50 !important;
        padding: 15px;
        border-radius: 5px;
        margin: 15px 0;
    }

    .chapter-content .alert {
        padding: 15px;
        border-radius: 5px;
        margin: 20px 0;
    }

    .chapter-content .alert-info {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
    }

    .chapter-content .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .chapter-content .alert-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .chapter-page .container-fluid {
            padding: 15px;
        }

        .chapter-navigation {
            position: relative !important;
            margin-bottom: 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Indicateur de progression de lecture
        function updateReadingProgress() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('readingProgress').style.width = scrolled + '%';
        }

        window.addEventListener('scroll', updateReadingProgress);

        // Toggle notes section
        document.getElementById('toggleNotes').addEventListener('click', function() {
            const notesSection = document.getElementById('notesSection');
            const icon = this.querySelector('i');

            if (notesSection.style.display === 'none') {
                notesSection.style.display = 'block';
                notesSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                this.classList.add('btn-warning');
                this.classList.remove('btn-outline-secondary');
                icon.classList.add('fas');
                icon.classList.remove('far');
            } else {
                notesSection.style.display = 'none';
                this.classList.remove('btn-warning');
                this.classList.add('btn-outline-secondary');
            }
        });

        // Toggle bookmark
        document.getElementById('toggleBookmark').addEventListener('click', function() {
            const icon = this.querySelector('i');

            if (this.classList.contains('btn-outline-secondary')) {
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-warning');
                icon.classList.remove('far');
                icon.classList.add('fas');

                // Animation de feedback
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);

                console.log('Page ajoutée aux favoris');
            } else {
                this.classList.add('btn-outline-secondary');
                this.classList.remove('btn-warning');
                icon.classList.add('far');
                icon.classList.remove('fas');
                console.log('Page retirée des favoris');
            }
        });

        // Toggle fullscreen
        document.getElementById('toggleFullscreen').addEventListener('click', function() {
            const icon = this.querySelector('i');

            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                icon.classList.remove('fa-expand');
                icon.classList.add('fa-compress');
                this.title = 'Quitter le plein écran';
            } else {
                document.exitFullscreen();
                icon.classList.remove('fa-compress');
                icon.classList.add('fa-expand');
                this.title = 'Mode plein écran';
            }
        });

        // Mark as complete avec AJAX
        document.getElementById('markComplete').addEventListener('click', function() {
            const button = this;
            const originalText = button.innerHTML;

            // Désactiver le bouton et montrer un état de chargement
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mise à jour...';

            // Faire l'appel AJAX
            fetch(`/api/cours/<?= $courseId ?>/chapitre/<?= $chapterNumber ?>/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour l'interface
                        button.innerHTML = '<i class="fas fa-check me-2"></i>Chapitre terminé !';
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-success');

                        // Mettre à jour la barre de progression
                        const progressBar = document.getElementById('progressBar');
                        const progressPercentage = document.getElementById('progressPercentage');

                        progressBar.style.width = data.progress + '%';
                        progressPercentage.textContent = data.progress + '%';

                        // Mettre à jour le texte de progression
                        const progressText = document.querySelector('.progress + small');
                        if (progressText) {
                            progressText.textContent = `${data.completedChapters} sur ${data.totalChapters} chapitres terminés`;
                        }

                        // Animation de succès
                        button.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            button.style.transform = 'scale(1)';
                        }, 200);

                        // Effet confetti
                        createConfetti();

                        // Afficher un message de succès
                        showNotification('Chapitre marqué comme terminé avec succès !', 'success');

                    } else {
                        // En cas d'erreur, remettre le bouton dans son état initial
                        button.disabled = false;
                        button.innerHTML = originalText;
                        showNotification(data.error || 'Erreur lors de la mise à jour', 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    button.disabled = false;
                    button.innerHTML = originalText;
                    showNotification('Erreur de connexion', 'error');
                });
        });

        // Fonction pour afficher des notifications
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(notification);

            // Auto-suppression après 5 secondes
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Animation des éléments au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observer tous les éléments de contenu
        document.querySelectorAll('.chapter-content > *').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Fonction pour créer un effet confetti
        function createConfetti() {
            const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7'];

            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.width = '10px';
                    confetti.style.height = '10px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.left = Math.random() * window.innerWidth + 'px';
                    confetti.style.top = '-10px';
                    confetti.style.zIndex = '9999';
                    confetti.style.borderRadius = '50%';
                    confetti.style.pointerEvents = 'none';

                    document.body.appendChild(confetti);

                    const animation = confetti.animate([{
                            transform: 'translateY(0) rotate(0deg)',
                            opacity: 1
                        },
                        {
                            transform: `translateY(${window.innerHeight + 20}px) rotate(720deg)`,
                            opacity: 0
                        }
                    ], {
                        duration: 3000,
                        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                    });

                    animation.onfinish = () => confetti.remove();
                }, i * 50);
            }
        }

        // Sauvegarde automatique des notes
        let notesSaveTimeout;
        const notesTextarea = document.querySelector('#notesSection textarea');

        if (notesTextarea) {
            notesTextarea.addEventListener('input', function() {
                clearTimeout(notesSaveTimeout);
                notesSaveTimeout = setTimeout(() => {
                    // Ici vous pourriez ajouter une requête AJAX pour sauvegarder
                    console.log('Notes auto-sauvegardées');
                }, 2000);
            });
        }
    });
</script>

<style>
    /* Ajouts de styles inline pour les animations */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .chapter-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
    }

    .chapter-content .chapter-link {
        color: #3498db;
        text-decoration: none;
        border-bottom: 1px dotted #3498db;
        transition: all 0.3s ease;
    }

    .chapter-content .chapter-link:hover {
        color: #2980b9;
        border-bottom: 1px solid #2980b9;
        background: rgba(52, 152, 219, 0.1);
        padding: 2px 4px;
        border-radius: 4px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .chapter-page .container-fluid {
            padding: 1rem;
        }

        .chapter-content-card .card-body {
            padding: 2rem 1.5rem;
        }

        .chapter-navigation {
            position: relative !important;
            margin-bottom: 2rem;
        }
    }
</style>