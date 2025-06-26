<?php

// Chargement des variables d'environnement
if (file_exists('../.env')) {
    $lines = file('../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && $line[0] !== '#') {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Configuration de l'environnement
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');
define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost:8080/');

// Configuration de la base de données
define('DB_HOST', $_ENV['DB_HOST'] ?? 'db');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'tuto_docker');
define('DB_USER', $_ENV['DB_USER'] ?? 'user');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? 'password');

// Configuration des erreurs selon l'environnement
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

// Configuration de la timezone
date_default_timezone_set('Europe/Paris');

// Configuration des sessions
ini_set('session.cookie_lifetime', 86400); // 24 heures
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Autoload des classes
spl_autoload_register(function ($className) {
    $directories = [
        '../app/Controllers/',
        '../app/Models/',
        '../app/Core/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Constantes de l'application
define('APP_NAME', 'Tuto Docker');
define('APP_VERSION', '1.0.0');
define('APP_DESCRIPTION', 'Tutoriel d\'apprentissage de Docker avec PHP');

// Chemins de l'application
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

// Configuration du mail (optionnel)
define('MAIL_HOST', $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com');
define('MAIL_PORT', $_ENV['MAIL_PORT'] ?? 587);
define('MAIL_USERNAME', $_ENV['MAIL_USERNAME'] ?? '');
define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] ?? '');

// Configuration de sécurité
define('CSRF_TOKEN_NAME', '_token');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes

// Configuration de pagination
define('DEFAULT_PAGE_SIZE', 10);
define('MAX_PAGE_SIZE', 100);

// Configuration des fichiers
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_UPLOAD_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

// Initialisation de la session
Session::start();

// Gestion des erreurs personnalisée
if (APP_ENV === 'production') {
    set_error_handler(function ($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity)) {
            return false;
        }

        $logMessage = date('Y-m-d H:i:s') . " - ERROR: {$message} in {$file} on line {$line}" . PHP_EOL;
        error_log($logMessage, 3, ROOT_PATH . '/logs/error.log');

        // En production, ne pas afficher l'erreur à l'utilisateur
        if ($severity === E_ERROR || $severity === E_USER_ERROR) {
            http_response_code(500);
            include APP_PATH . '/Views/errors/500.php';
            exit;
        }

        return true;
    });

    set_exception_handler(function ($exception) {
        $logMessage = date('Y-m-d H:i:s') . " - EXCEPTION: " . $exception->getMessage() .
            " in " . $exception->getFile() . " on line " . $exception->getLine() . PHP_EOL;
        error_log($logMessage, 3, ROOT_PATH . '/logs/error.log');

        http_response_code(500);
        include APP_PATH . '/Views/errors/500.php';
        exit;
    });
}

// Fonctions utilitaires globales
function redirect($url)
{
    header("Location: {$url}");
    exit;
}

function url($path = '')
{
    return BASE_URL . ltrim($path, '/');
}

function asset($path)
{
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

function old($key, $default = '')
{
    return Session::getOldInput($key, $default);
}

function flash($type = null)
{
    if ($type) {
        return Session::getFlash($type);
    }
    return Session::getAllFlash();
}

function csrf_token()
{
    return Session::getCsrfToken();
}

function csrf_field()
{
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . csrf_token() . '">';
}

function is_logged_in()
{
    return Session::isLoggedIn();
}

function current_user()
{
    if (is_logged_in()) {
        static $user = null;
        if ($user === null) {
            $userModel = new User();
            $user = $userModel->find(Session::getUserId());
        }
        return $user;
    }
    return null;
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
