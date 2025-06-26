<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - Tuto Docker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="text-center">
            <div class="mb-4">
                <i class="fab fa-docker fa-5x text-primary opacity-50"></i>
            </div>

            <h1 class="display-1 fw-bold text-primary">404</h1>
            <h2 class="h3 mb-3">Page non trouvée</h2>
            <p class="lead text-muted mb-4">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
            </p>

            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-home me-2"></i>
                    Retour à l'accueil
                </a>
                <a href="<?= BASE_URL ?>cours" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-book-open me-2"></i>
                    Voir les cours
                </a>
                <a href="<?= BASE_URL ?>contact" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-envelope me-2"></i>
                    Nous contacter
                </a>
            </div>

            <div class="mt-5">
                <small class="text-muted">
                    Si vous pensez qu'il s'agit d'une erreur,
                    <a href="<?= BASE_URL ?>contact" class="text-decoration-none">contactez-nous</a>.
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>