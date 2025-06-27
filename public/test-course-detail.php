<?php
// Test simple pour afficher le détail du cours
require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Session.php';
require_once '../app/Models/Course.php';

// Simuler une session utilisateur
Session::start();
Session::set('user_id', 1);
Session::set('username', 'test_user');

// Charger le cours
$courseModel = new Course();
$course = $courseModel->find(1);
$moduleContent = $courseModel->getModuleContent(1);

echo "<h1>Test du contenu du module 1</h1>";
echo "<h2>Cours : " . htmlspecialchars($course['title']) . "</h2>";
echo "<p>Description : " . htmlspecialchars($course['description']) . "</p>";

echo "<h3>Contenu du module chargé :</h3>";
if (!empty($moduleContent)) {
    echo "<h4>README trouvé : " . (isset($moduleContent['readme']) ? 'OUI' : 'NON') . "</h4>";

    if (isset($moduleContent['chapters'])) {
        echo "<h4>Chapitres trouvés : " . count($moduleContent['chapters']) . "</h4>";
        foreach ($moduleContent['chapters'] as $index => $chapter) {
            echo "<div style='border: 1px solid #ccc; margin: 10px 0; padding: 10px;'>";
            echo "<h5>Chapitre " . ($index + 1) . " : " . htmlspecialchars($chapter['title']) . "</h5>";
            echo "<div style='background: #f5f5f5; padding: 10px; max-height: 200px; overflow-y: auto;'>";
            echo nl2br(htmlspecialchars(substr($chapter['content'], 0, 500)));
            if (strlen($chapter['content']) > 500) {
                echo "<br><em>... (contenu tronqué)</em>";
            }
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun chapitre trouvé</p>";
    }
} else {
    echo "<p>Aucun contenu de module trouvé</p>";
}

// Test du chemin
$moduleDir = "content/modules/module-01";
$basePath = dirname(dirname(__FILE__)) . "/" . $moduleDir;
echo "<h4>Chemin recherché : " . $basePath . "</h4>";
echo "<h4>README existe : " . (file_exists($basePath . "/README.md") ? 'OUI' : 'NON') . "</h4>";
if (file_exists($basePath . "/README.md")) {
    echo "<h4>Taille du README : " . filesize($basePath . "/README.md") . " octets</h4>";
}
