<?php
// Debug complet du routage

require_once '../config/config.php';

echo "=== Debug du routage ===\n\n";

// Test des routes
$router = new Router();
require_once '../config/routes.php';

echo "Routes enregistrées: " . (method_exists($router, 'getRoutes') ? "Oui" : "Non") . "\n";

// Simuler une requête
$_SERVER['REQUEST_URI'] = '/cours/1';
$_SERVER['REQUEST_METHOD'] = 'GET';

echo "URI testée: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Méthode: " . $_SERVER['REQUEST_METHOD'] . "\n";

// Tenter de dispatcher
try {
    echo "Tentative de dispatch...\n";
    $router->dispatch('/cours/1');
    echo "✅ Dispatch OK\n";
} catch (Exception $e) {
    echo "❌ Erreur dispatch: " . $e->getMessage() . "\n";
}

echo "\n=== Debug terminé ===\n";
