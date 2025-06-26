<footer class="footer-custom mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <img src="/assets/img/logo.svg" alt="Logo" width="30" height="30" class="me-2">
                    Tuto Docker
                </h5>
                <p class="mb-3">
                    Apprenez Docker facilement avec nos tutoriels interactifs et nos cours pratiques.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <h6 class="fw-bold mb-3">Navigation</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= url('/') ?>" class="text-light text-decoration-none">Accueil</a></li>
                    <li><a href="<?= url('/cours') ?>" class="text-light text-decoration-none">Cours</a></li>
                    <li><a href="<?= url('/contact') ?>" class="text-light text-decoration-none">Contact</a></li>
                    <li><a href="<?= url('/about') ?>" class="text-light text-decoration-none">À propos</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Cours populaires</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none">Introduction à Docker</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Docker Compose</a></li>
                    <li><a href="#" class="text-light text-decoration-none">PHP avec Docker</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Déploiement</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Contact</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        contact@tuto-docker.com
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        +33 1 23 45 67 89
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Paris, France
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">
                    &copy; <?= date('Y') ?> Tuto Docker. Tous droits réservés.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-muted">
                    Version <?= APP_VERSION ?> |
                    <a href="#" class="text-light">Mentions légales</a> |
                    <a href="#" class="text-light">Politique de confidentialité</a>
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Font Awesome pour les icônes -->
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>