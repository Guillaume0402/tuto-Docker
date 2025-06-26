<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header text-center">
                    <h2 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Créer un compte
                    </h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= url('/register') ?>" class="form-custom" data-validate>
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Prénom
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="first_name"
                                        name="first_name"
                                        value="<?= old('first_name') ?>"
                                        placeholder="Votre prénom">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="last_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Nom
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="last_name"
                                        name="last_name"
                                        value="<?= old('last_name') ?>"
                                        placeholder="Votre nom">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-at me-1"></i>
                                Nom d'utilisateur
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="<?= old('username') ?>"
                                required
                                placeholder="Choisissez un nom d'utilisateur"
                                pattern="[a-zA-Z0-9_-]{3,20}"
                                title="Le nom d'utilisateur doit contenir entre 3 et 20 caractères (lettres, chiffres, - et _ uniquement)">
                            <div class="form-text">
                                Entre 3 et 20 caractères. Lettres, chiffres, tirets et underscores autorisés.
                            </div>
                        </div>

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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Mot de passe
                                    </label>
                                    <div class="position-relative">
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password"
                                            name="password"
                                            required
                                            minlength="6"
                                            placeholder="Votre mot de passe">
                                        <button
                                            type="button"
                                            class="btn btn-link position-absolute top-50 end-0 translate-middle-y"
                                            onclick="togglePassword('password')"
                                            style="border: none; background: none; z-index: 10;">
                                            <i class="fas fa-eye" id="password-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        Au moins 6 caractères.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Confirmer le mot de passe
                                    </label>
                                    <div class="position-relative">
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="confirm_password"
                                            name="confirm_password"
                                            required
                                            placeholder="Confirmez votre mot de passe">
                                        <button
                                            type="button"
                                            class="btn btn-link position-absolute top-50 end-0 translate-middle-y"
                                            onclick="togglePassword('confirm_password')"
                                            style="border: none; background: none; z-index: 10;">
                                            <i class="fas fa-eye" id="confirm_password-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="terms"
                                    name="terms"
                                    required>
                                <label class="form-check-label" for="terms">
                                    J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a>
                                    et la <a href="#" class="text-decoration-none">politique de confidentialité</a>
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="newsletter"
                                    name="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Je souhaite recevoir les nouveautés et offres spéciales par email
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-custom mb-3">
                            <i class="fas fa-user-plus me-2"></i>
                            Créer mon compte
                        </button>

                        <div class="text-center">
                            <p class="mb-0">
                                Déjà un compte ?
                                <a href="<?= url('/login') ?>" class="text-decoration-none fw-bold">
                                    Connectez-vous ici
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId + '-eye');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    // Validation de la confirmation de mot de passe
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;

        if (password !== confirmPassword) {
            this.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            this.setCustomValidity('');
        }
    });
</script>