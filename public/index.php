<?php
// Point d'entrée unique de l'application

// Inclusion des fichiers de configuration
require_once '../config/config.php';

// Démarrage de la session
Session::start();

// Démarrage de la session
Session::start();

// Récupération de l'URL demandée
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($scriptName);

// Nettoyage de l'URI
if ($basePath !== '/') {
    $requestUri = substr($requestUri, strlen($basePath));
}

// Suppression des paramètres GET de l'URI
$requestUri = strtok($requestUri, '?');

// Instance du routeur et chargement des routes
$router = new Router();
require_once '../config/routes.php';

// Traitement de la requête
try {
    $router->dispatch($requestUri);
} catch (Exception $e) {
    // Gestion des erreurs
    error_log("Erreur de routage: " . $e->getMessage());

    // Affichage d'une page d'erreur 404
    http_response_code(404);
    include '../app/Views/errors/404.php';
}
