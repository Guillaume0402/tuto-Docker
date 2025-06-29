<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Tuto Docker' ?></title>
    <meta name="description" content="<?= $description ?? 'Apprenez Docker avec nos tutoriels interactifs' ?>">

    <!-- Bootstrap CSS (CDN temporaire, remplacer par la compilation SCSS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/chapter.css') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/logo.svg') ?>">
</head>

<body>
    <!-- Navigation -->
    <?php include 'header.php'; ?>

    <!-- Messages flash -->
    <?php if (flash()): ?>
        <div class="container mt-3">
            <?php foreach (flash() as $type => $message): ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Contenu principal -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript personnalisé -->
    <script src="<?= asset('js/app.js') ?>"></script>

    <!-- Scripts additionnels si spécifiés -->
    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= asset('js/' . $script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>