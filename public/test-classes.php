<?php
echo "Test de chargemaent des classes\n";

// Test d'inclusion du config
try {
    require_once '../config/config.php';
    echo "✅ Config chargé\n";
} catch (Exception $e) {
    echo "❌ Erreur config: " . $e->getMessage() . "\n";
    exit;
}

// Test de la classe Session
try {
    $sessionTest = new Session();
    echo "✅ Classe Session chargée\n";
} catch (Exception $e) {
    echo "❌ Erreur Session: " . $e->getMessage() . "\n";
}

// Test de la classe Course
try {
    $courseTest = new Course();
    echo "✅ Classe Course chargée\n";
} catch (Exception $e) {
    echo "❌ Erreur Course: " . $e->getMessage() . "\n";
}

// Test du Router
try {
    $routerTest = new Router();
    echo "✅ Classe Router chargée\n";
} catch (Exception $e) {
    echo "❌ Erreur Router: " . $e->getMessage() . "\n";
}

echo "\n=== Test terminé ===\n";
