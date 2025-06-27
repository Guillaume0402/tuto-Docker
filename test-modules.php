#!/usr/bin/env php
<?php
/**
 * Script pour tester le chargement du contenu des modules
 */

require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Course.php';

echo "=== Test du chargement des modules ===\n\n";

$courseModel = new Course();

// Test du module 1
echo "1. Test du Module 1...\n";
$module1Content = $courseModel->getModuleContent(1);

echo "   - README chargé: " . (isset($module1Content['readme']) && $module1Content['readme'] ? "✓ OUI" : "✗ NON") . "\n";
echo "   - TP chargé: " . (isset($module1Content['tp']) && $module1Content['tp'] ? "✓ OUI" : "✗ NON") . "\n";
echo "   - Quiz chargé: " . (isset($module1Content['quiz']) && $module1Content['quiz'] ? "✓ OUI" : "✗ NON") . "\n";
echo "   - Resources chargées: " . (isset($module1Content['resources']) && $module1Content['resources'] ? "✓ OUI" : "✗ NON") . "\n";
echo "   - Chapitres extraits: " . count($module1Content['chapters']) . " chapitres\n";

if (!empty($module1Content['chapters'])) {
    echo "\n   Chapitres détectés:\n";
    foreach ($module1Content['chapters'] as $chapter) {
        echo "   - Chapitre " . $chapter['id'] . ": " . substr($chapter['title'], 0, 50) . "\n";
        echo "     Contenu: " . (strlen($chapter['content']) > 0 ? strlen($chapter['content']) . " caractères" : "Vide") . "\n";
    }
}

// Test des autres modules
echo "\n2. Test des autres modules...\n";
for ($i = 2; $i <= 5; $i++) {
    $moduleContent = $courseModel->getModuleContent($i);
    $hasReadme = isset($moduleContent['readme']) && $moduleContent['readme'];
    echo "   - Module $i: " . ($hasReadme ? "✓ Contenu trouvé" : "✗ Pas de contenu") . "\n";
}

echo "\n=== Test terminé ===\n";
