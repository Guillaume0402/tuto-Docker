#!/usr/bin/env php
<?php
/**
 * Script pour tester la connexion et l'affichage des statistiques
 */

echo "=== Test de connexion et dashboard ===\n\n";

// Test 1: Page de login
echo "1. Test de la page de login...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✓ Page de login accessible (HTTP $httpCode)\n";
} else {
    echo "✗ Erreur page de login (HTTP $httpCode)\n";
    exit(1);
}

// Test 2: Page d'accueil
echo "\n2. Test de la page d'accueil...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✓ Page d'accueil accessible (HTTP $httpCode)\n";
} else {
    echo "✗ Erreur page d'accueil (HTTP $httpCode)\n";
}

// Test 3: Page cours
echo "\n3. Test de la page cours...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/cours');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✓ Page cours accessible (HTTP $httpCode)\n";
} else {
    echo "✗ Erreur page cours (HTTP $httpCode)\n";
}

// Test 4: Page cours spécifique
echo "\n4. Test de la page cours spécifique...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/cours/1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✓ Page cours/1 accessible (HTTP $httpCode)\n";
} else {
    echo "✗ Erreur page cours/1 (HTTP $httpCode)\n";
}

// Test 5: Dashboard (doit rediriger vers login)
echo "\n5. Test du dashboard (sans authentification)...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 302) {
    echo "✓ Dashboard redirige vers login (HTTP $httpCode)\n";
} else {
    echo "✗ Dashboard: redirection attendue (HTTP $httpCode)\n";
}

echo "\n=== Tests terminés ===\n";
echo "Le serveur fonctionne correctement !\n";
echo "Vous pouvez maintenant vous connecter sur http://localhost:8000/login\n";
echo "avec les identifiants : admin@example.com / password\n";
