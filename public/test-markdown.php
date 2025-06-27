<?php
// Test du rendu Markdown

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
require_once '../app/Models/Course.php';

echo "=== Test du rendu Markdown ===\n\n";

$courseModel = new Course();

// Test avec du contenu Markdown simple
$markdownText = "
À la fin de ce module, vous serez capable de :

-   ✅ **Expliquer** ce qu'est Docker et pourquoi l'utiliser
-   ✅ **Différencier** conteneurs et machines virtuelles
-   ✅ **Identifier** les composants de l'écosystème Docker
-   ✅ **Installer** Docker sur votre système
-   ✅ **Exécuter** votre premier conteneur Docker

### Définition

**Docker** est une plateforme de conteneurisation qui permet d'empaqueter, distribuer et exécuter des applications dans des environnements isolés appelés **conteneurs**.

Utilisez `docker run hello-world` pour tester.
";

echo "Contenu Markdown original:\n";
echo "================================\n";
echo $markdownText . "\n\n";

echo "Contenu HTML converti:\n";
echo "================================\n";
echo $courseModel->markdownToHtml($markdownText) . "\n\n";

echo "=== Test terminé ===\n";
