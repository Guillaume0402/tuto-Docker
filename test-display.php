<?php
// Test d'affichage du contenu du module 1 sur la page

// Créer une classe Database factice pour le test
class Database
{
    public static function getInstance()
    {
        return new self();
    }
    public function getConnection()
    {
        return null; // Simulation d'absence de base de données
    }
}

// Inclure seulement le modèle Course
require_once 'app/Models/Course.php';

echo "=== Test d'affichage du module 1 ===\n\n";

// Simuler les données comme dans le contrôleur
$courseModel = new Course();
$course = $courseModel->find(1);
$moduleContent = $courseModel->getModuleContent(1);

echo "Cours trouvé: " . ($course ? "✅ " . $course['title'] : "❌ Non trouvé") . "\n";
echo "Contenu du module chargé: " . (isset($moduleContent['readme']) ? "✅ README présent" : "❌ README manquant") . "\n";

if (isset($moduleContent['chapters'])) {
    echo "Chapitres extraits: ✅ " . count($moduleContent['chapters']) . " chapitres\n\n";

    echo "Liste des chapitres:\n";
    foreach ($moduleContent['chapters'] as $i => $chapter) {
        echo "  " . ($i + 1) . ". " . $chapter['title'] . "\n";
        echo "     Contenu: " . strlen($chapter['content']) . " caractères\n";
        echo "     Aperçu: " . substr(str_replace(["\n", "\r"], " ", $chapter['content']), 0, 100) . "...\n\n";
    }

    // Vérifier l'extraction des objectifs pédagogiques
    if (preg_match('/## 🎯 Objectifs pédagogiques\s*\n\n(.*?)\n\n##/s', $moduleContent['readme'], $matches)) {
        echo "Objectifs pédagogiques extraits: ✅\n";
        echo "Contenu: " . substr($matches[1], 0, 200) . "...\n";
    } else {
        echo "Objectifs pédagogiques: ❌ Non extraits\n";
    }
} else {
    echo "Chapitres: ❌ Non extraits\n";
}

echo "\n=== Test terminé ===\n";
