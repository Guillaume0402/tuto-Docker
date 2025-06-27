<?php

/**
 * Script de test pour vérifier les statistiques du dashboard
 */

// Simuler un environnement de test
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Enrollment.php';

echo "=== Test des statistiques du Dashboard ===\n\n";

// Test du modèle Enrollment
echo "1. Test du modèle Enrollment...\n";
$enrollment = new Enrollment();

// Test des statistiques utilisateur (sans DB, utilise les données statiques)
$stats = $enrollment->getUserStats(1);
echo "Statistiques utilisateur (ID: 1):\n";
echo "- Cours suivis: {$stats['total_enrolled']}\n";
echo "- Cours terminés: {$stats['completed_courses']}\n";
echo "- Cours en cours: {$stats['in_progress_courses']}\n";
echo "- Temps total: {$stats['total_hours']}h\n\n";

// Test des cours utilisateur
echo "2. Test des cours utilisateur...\n";
$userCourses = $enrollment->getUserCourses(1);
echo "Cours de l'utilisateur (ID: 1):\n";
foreach ($userCourses as $course) {
    echo "- {$course['title']} ({$course['progress']}% terminé, niveau {$course['level']})\n";
}

echo "\n3. Test de la fonction timeAgo...\n";
function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) return 'Il y a quelques secondes';
    if ($time < 3600) return 'Il y a ' . floor($time / 60) . ' min';
    if ($time < 86400) return 'Il y a ' . floor($time / 3600) . ' h';
    if ($time < 2592000) return 'Il y a ' . floor($time / 86400) . ' j';
    if ($time < 31536000) return 'Il y a ' . floor($time / 2592000) . ' mois';
    return 'Il y a ' . floor($time / 31536000) . ' an' . (floor($time / 31536000) > 1 ? 's' : '');
}

// Test de différentes dates
$now = date('Y-m-d H:i:s');
$testDates = [
    date('Y-m-d H:i:s', strtotime('-2 hours')),    // Il y a 2 heures
    date('Y-m-d H:i:s', strtotime('-1 day')),      // Hier
    date('Y-m-d H:i:s', strtotime('-3 days')),     // Il y a 3 jours
    date('Y-m-d H:i:s', strtotime('-1 month')),    // Il y a un mois
];

foreach ($testDates as $date) {
    echo "Date: $date -> " . timeAgo($date) . "\n";
}

echo "\n=== Test terminé avec succès ! ===\n";
