<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header text-center">
                    <h2 class="mb-0">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Connexion
                    </h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= url('/login') ?>" class="form-custom" data-validate>
                        <?= csrf_field() ?>

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
                                    placeholder="Votre mot de passe">
                                <button
                                    type="button"
                                    class="btn btn-link position-absolute top-50 end-0 translate-middle-y"
                                    onclick="togglePassword('password')"
                                    style="border: none; background: none; z-index: 10;">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="remember"
                                    name="remember">
                                <label class="form-check-label" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-custom mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Se connecter
                        </button>

                        <div class="text-center">
                            <p class="mb-2">
                                <a href="<?= url('/forgot-password') ?>" class="text-decoration-none">
                                    Mot de passe oublié ?
                                </a>
                            </p>
                            <p class="mb-0">
                                Pas encore de compte ?
                                <a href="<?= url('/register') ?>" class="text-decoration-none fw-bold">
                                    Inscrivez-vous ici
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Démonstration -->
            <div class="alert alert-info mt-4" role="alert">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>
                    Compte de démonstration
                </h6>
                <p class="mb-2">Pour tester l'application, vous pouvez utiliser :</p>
                <ul class="mb-0">
                    <li><strong>Email :</strong> admin@example.com</li>
                    <li><strong>Mot de passe :</strong> password</li>
                </ul>
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
</script>