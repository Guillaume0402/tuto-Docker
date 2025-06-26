<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card card-custom">
                <div class="card-header text-center">
                    <h2 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        Contactez-nous
                    </h2>
                    <p class="text-muted mt-2 mb-0">
                        Une question ? Un problème ? Nous sommes là pour vous aider !
                    </p>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= url('/contact') ?>" class="form-custom" data-validate>
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Nom complet
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        value="<?= old('name') ?>"
                                        required
                                        placeholder="Votre nom et prénom">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        Adresse email
                                    </label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        value="<?= old('email') ?>"
                                        required
                                        placeholder="votre@email.com">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="subject" class="form-label">
                                <i class="fas fa-tag me-1"></i>
                                Sujet
                            </label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Choisissez un sujet</option>
                                <option value="Question générale" <?= old('subject') === 'Question générale' ? 'selected' : '' ?>>
                                    Question générale
                                </option>
                                <option value="Problème technique" <?= old('subject') === 'Problème technique' ? 'selected' : '' ?>>
                                    Problème technique
                                </option>
                                <option value="Cours et contenu" <?= old('subject') === 'Cours et contenu' ? 'selected' : '' ?>>
                                    Question sur un cours
                                </option>
                                <option value="Facturation" <?= old('subject') === 'Facturation' ? 'selected' : '' ?>>
                                    Facturation et paiement
                                </option>
                                <option value="Suggestion" <?= old('subject') === 'Suggestion' ? 'selected' : '' ?>>
                                    Suggestion d'amélioration
                                </option>
                                <option value="Partenariat" <?= old('subject') === 'Partenariat' ? 'selected' : '' ?>>
                                    Partenariat
                                </option>
                                <option value="Autre" <?= old('subject') === 'Autre' ? 'selected' : '' ?>>
                                    Autre
                                </option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment me-1"></i>
                                Message
                            </label>
                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="6"
                                required
                                placeholder="Décrivez votre demande en détail..."><?= old('message') ?></textarea>
                            <div class="form-text">
                                Minimum 10 caractères. Soyez aussi précis que possible pour une réponse rapide.
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="copy"
                                    name="copy">
                                <label class="form-check-label" for="copy">
                                    Recevoir une copie de ce message par email
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg btn-custom">
                                <i class="fas fa-paper-plane me-2"></i>
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations de contact -->
    <div class="row mt-5">
        <div class="col-lg-4 mb-4">
            <div class="card card-custom text-center h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-envelope fa-3x text-primary"></i>
                    </div>
                    <h5>Email</h5>
                    <p class="text-muted">
                        <a href="mailto:contact@tuto-docker.com" class="text-decoration-none">
                            contact@tuto-docker.com
                        </a>
                    </p>
                    <small class="text-muted">Réponse sous 24h</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-custom text-center h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-phone fa-3x text-success"></i>
                    </div>
                    <h5>Téléphone</h5>
                    <p class="text-muted">
                        <a href="tel:+33123456789" class="text-decoration-none">
                            +33 1 23 45 67 89
                        </a>
                    </p>
                    <small class="text-muted">Lun-Ven 9h-18h</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-custom text-center h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fab fa-discord fa-3x text-info"></i>
                    </div>
                    <h5>Discord</h5>
                    <p class="text-muted">
                        Rejoignez notre communauté
                    </p>
                    <a href="#" class="btn btn-outline-info btn-sm">
                        Rejoindre le serveur
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ rapide -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        Questions Fréquentes
                    </h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    Comment accéder aux cours après inscription ?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Après inscription et paiement, vous recevrez un email de confirmation avec vos accès.
                                    Vous pourrez ensuite vous connecter à votre dashboard pour accéder à tous vos cours.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    Quels sont les prérequis pour les cours Docker ?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Les cours débutants ne nécessitent aucun prérequis. Pour les cours intermédiaires et avancés,
                                    une connaissance de base de Linux et des concepts de développement est recommandée.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    Puis-je obtenir un remboursement ?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Nous offrons une garantie de remboursement de 30 jours si vous n'êtes pas satisfait du cours.
                                    Contactez-nous pour plus d'informations.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    Les cours sont-ils mis à jour ?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, nous mettons régulièrement à jour nos cours pour suivre les évolutions de Docker
                                    et des meilleures pratiques de l'industrie.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messageTextarea = document.getElementById('message');
        const form = document.querySelector('form[data-validate]');

        // Validation en temps réel du message
        messageTextarea.addEventListener('input', function() {
            if (this.value.length < 10) {
                this.setCustomValidity('Le message doit contenir au moins 10 caractères');
            } else {
                this.setCustomValidity('');
            }
        });

        // Pré-remplir avec les données utilisateur si connecté
        <?php if (is_logged_in()): ?>
            <?php $currentUser = current_user(); ?>
            <?php if ($currentUser): ?>
                document.getElementById('name').value = '<?= htmlspecialchars(trim(($currentUser['first_name'] ?? '') . ' ' . ($currentUser['last_name'] ?? ''))) ?: $currentUser['username'] ?>';
                document.getElementById('email').value = '<?= htmlspecialchars($currentUser['email']) ?>';
            <?php endif; ?>
        <?php endif; ?>
    });
</script>