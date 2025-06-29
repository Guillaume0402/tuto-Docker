<?php

class CourseController extends Controller
{
    public function index()
    {
        // Utiliser les données statiques définies dans la vue avec les bons instructeurs
        $courses = null; // Forcer l'utilisation des données statiques de la vue

        $data = [
            'title' => 'Nos Cours - Tuto Docker',
            'courses' => $courses
        ];

        $this->view('cours', $data);
    }

    public function show($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::get('user_id')) {
            Session::setFlash('info', 'Vous devez être connecté pour accéder au contenu des cours');
            header('Location: /login');
            exit;
        }

        $courseModel = new Course();
        $course = $courseModel->find($id);

        if (!$course) {
            header('Location: /cours');
            exit;
        }

        // Vérifier si l'utilisateur est inscrit au cours
        $userId = Session::get('user_id');
        $isEnrolled = false;
        if ($userId) {
            $isEnrolled = $courseModel->isUserEnrolled($userId, $id);
        }

        $data = [
            'title' => $course['title'] . ' - Tuto Docker',
            'course' => $course,
            'courseModel' => $courseModel,
            'isEnrolled' => $isEnrolled
        ];

        $this->view('course-detail', $data);
    }

    public function enroll($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::get('user_id')) {
            Session::setFlash('error', 'Vous devez être connecté pour vous inscrire à un cours');
            header('Location: /login');
            exit;
        }

        $userId = Session::get('user_id');
        $courseModel = new Course();
        $course = $courseModel->find($id);

        if (!$course) {
            Session::setFlash('error', 'Cours introuvable');
            header('Location: /cours');
            exit;
        }

        // Vérifier si l'utilisateur n'est pas déjà inscrit
        if ($courseModel->isUserEnrolled($userId, $id)) {
            Session::setFlash('info', 'Vous êtes déjà inscrit à ce cours');
        } else {
            if ($courseModel->enrollUser($userId, $id)) {
                Session::setFlash('success', 'Inscription réussie au cours : ' . $course['title']);
            } else {
                Session::setFlash('error', 'Erreur lors de l\'inscription');
            }
        }

        header('Location: /cours/' . $id);
        exit;
    }

    public function chapter($id, $chapterNumber)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::get('user_id')) {
            Session::setFlash('info', 'Vous devez être connecté pour accéder au contenu des cours');
            header('Location: /login');
            exit;
        }

        $courseModel = new Course();
        $course = $courseModel->find($id);

        if (!$course) {
            header('Location: /cours');
            exit;
        }

        // Vérifier si l'utilisateur est inscrit au cours
        $userId = Session::get('user_id');
        $isEnrolled = false;
        if ($userId) {
            $isEnrolled = $courseModel->isUserEnrolled($userId, $id);
        }

        if (!$isEnrolled) {
            Session::setFlash('error', 'Vous devez être inscrit à ce cours pour accéder aux chapitres');
            header('Location: /cours/' . $id);
            exit;
        }

        // Charger le contenu du chapitre
        $chapterContent = $this->loadChapterContent($id, $chapterNumber);

        if (!$chapterContent) {
            Session::setFlash('error', 'Chapitre non trouvé');
            header('Location: /cours/' . $id);
            exit;
        }

        // Récupérer la progression actuelle
        $enrollmentModel = new Enrollment();
        $totalChapters = 5; // Nombre total de chapitres pour ce cours
        $currentProgress = $enrollmentModel->getCourseProgress($userId, $id, $totalChapters);
        $completedChapters = $enrollmentModel->getCompletedChapters($userId, $id);

        $data = [
            'title' => $chapterContent['title'] . ' - ' . $course['title'],
            'course' => $course,
            'chapter' => $chapterContent,
            'chapterNumber' => $chapterNumber,
            'courseId' => $id,
            'currentProgress' => $currentProgress,
            'completedChapters' => $completedChapters,
            'totalChapters' => $totalChapters
        ];

        $this->view('chapter', $data);
    }

    /**
     * Marque un chapitre comme terminé (AJAX)
     */
    public function markChapterComplete($id, $chapterNumber)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::get('user_id')) {
            http_response_code(401);
            echo json_encode(['error' => 'Utilisateur non connecté']);
            exit;
        }

        $userId = Session::get('user_id');
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();

        // Vérifier si l'utilisateur est inscrit au cours
        if (!$courseModel->isUserEnrolled($userId, $id)) {
            http_response_code(403);
            echo json_encode(['error' => 'Vous devez être inscrit à ce cours']);
            exit;
        }

        // Marquer le chapitre comme terminé
        if ($enrollmentModel->markChapterComplete($userId, $id, $chapterNumber)) {
            // Calculer la nouvelle progression
            $totalChapters = 5; // Nombre total de chapitres pour ce cours
            $newProgress = $enrollmentModel->getCourseProgress($userId, $id, $totalChapters);
            $completedChapters = $enrollmentModel->getCompletedChapters($userId, $id);

            // Mettre à jour la progression générale du cours
            $enrollmentModel->updateProgress($userId, $id, $newProgress);

            // Retourner la réponse JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'progress' => $newProgress,
                'completedChapters' => $completedChapters,
                'totalChapters' => $totalChapters,
                'message' => 'Chapitre marqué comme terminé avec succès !'
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la mise à jour de la progression']);
            exit;
        }
    }

    private function loadChapterContent($courseId, $chapterNumber)
    {
        // Mapper les cours aux modules
        $courseToModuleMap = [
            1 => 'module-01', // Introduction à Docker
            2 => 'module-02', // Installation et Configuration  
            3 => 'module-03', // Premiers Conteneurs
            4 => 'module-04', // Images Docker
            5 => 'module-05'  // Réseaux Docker
        ];

        $moduleDir = $courseToModuleMap[$courseId] ?? null;
        if (!$moduleDir) {
            return null;
        }

        // Définir le contenu des chapitres selon le cours
        if ($courseId == 1) { // Introduction à Docker
            $chapters = [
                1 => [
                    'title' => '🧱 Introduction à Docker',
                    'content' => $this->loadModuleContent($moduleDir, 'introduction'),
                    'duration' => '45 min',
                    'type' => 'theory'
                ],
                2 => [
                    'title' => '📊 Conteneurs vs Machines Virtuelles',
                    'content' => $this->loadModuleContent($moduleDir, 'containers-vs-vm'),
                    'duration' => '30 min',
                    'type' => 'theory'
                ],
                3 => [
                    'title' => '🧰 Concepts fondamentaux',
                    'content' => $this->loadModuleContent($moduleDir, 'fundamentals'),
                    'duration' => '60 min',
                    'type' => 'theory'
                ],
                4 => [
                    'title' => '💻 Installation de Docker',
                    'content' => $this->loadModuleContent($moduleDir, 'installation'),
                    'duration' => '45 min',
                    'type' => 'practical'
                ],
                5 => [
                    'title' => '👋 Premier conteneur Hello World',
                    'content' => $this->loadModuleContent($moduleDir, 'hello-world'),
                    'duration' => '30 min',
                    'type' => 'practical'
                ]
            ];
        } else {
            // Chapitres par défaut pour les autres cours
            $chapters = [
                1 => [
                    'title' => '🧱 Introduction',
                    'content' => 'Contenu à venir pour ce module...',
                    'duration' => '45 min',
                    'type' => 'theory'
                ]
            ];
        }

        return $chapters[$chapterNumber] ?? null;
    }
    private function loadModuleContent($moduleDir, $section)
    {
        // Contenu simple et direct selon la section
        switch ($section) {
            case 'introduction':
                return $this->getIntroductionContent();
            case 'containers-vs-vm':
                return $this->getContainersVsVmContent();
            case 'fundamentals':
                return $this->getFundamentalsContent();
            case 'installation':
                return $this->getInstallationContent();
            case 'hello-world':
                return $this->getHelloWorldContent();
            default:
                return "Contenu à venir...";
        }
    }

    private function getIntroductionContent()
    {
        return '
        <h2>Qu\'est-ce que Docker ?</h2>
        
        <p><strong>Docker</strong> est un outil qui permet d\'empaqueter vos applications dans des "conteneurs".</p>
        
        <h3>Pourquoi utiliser Docker ?</h3>
        <ul>
            <li><strong>Simplicité :</strong> Votre application fonctionne partout de la même façon</li>
            <li><strong>Rapidité :</strong> Démarrage en quelques secondes</li>
            <li><strong>Efficacité :</strong> Utilise moins de ressources qu\'une machine virtuelle</li>
        </ul>
        
        <h3>Un exemple concret</h3>
        <p>Imaginez que vous développez un site web. Avec Docker :</p>
        <ul>
            <li>✅ Ça marche sur votre ordinateur</li>
            <li>✅ Ça marche sur l\'ordinateur de votre collègue</li>
            <li>✅ Ça marche sur le serveur de production</li>
        </ul>
        
        <div class="alert alert-info">
            <strong>En résumé :</strong> Docker évite le fameux "ça marche sur ma machine" !
        </div>';
    }

    private function getContainersVsVmContent()
    {
        return '
        <h2>Conteneurs vs Machines Virtuelles</h2>
        
        <h3>Machine Virtuelle (l\'ancienne méthode)</h3>
        <ul>
            <li>Lourd : chaque VM a son propre système d\'exploitation</li>
            <li>Lent : prend plusieurs minutes à démarrer</li>
            <li>Gourmand : utilise beaucoup de RAM et d\'espace disque</li>
        </ul>
        
        <h3>Conteneur Docker (la nouvelle méthode)</h3>
        <ul>
            <li>Léger : partage le système d\'exploitation de l\'hôte</li>
            <li>Rapide : démarre en quelques secondes</li>
            <li>Efficace : utilise moins de ressources</li>
        </ul>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-warning">
                    <div class="card-header bg-warning">
                        <h5>🐌 Machine Virtuelle</h5>
                    </div>
                    <div class="card-body">
                        <p>1 Application = 1 VM complète<br>
                        RAM : 2-4 GB par VM<br>
                        Démarrage : 2-5 minutes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5>🚀 Conteneur Docker</h5>
                    </div>
                    <div class="card-body">
                        <p>1 Application = 1 conteneur léger<br>
                        RAM : 10-100 MB par conteneur<br>
                        Démarrage : 1-3 secondes</p>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function getFundamentalsContent()
    {
        return '
        <h2>Les concepts de base</h2>
        
        <h3>🏗️ Image Docker</h3>
        <p>Une <strong>image</strong> c\'est comme un modèle ou un plan de construction :</p>
        <ul>
            <li>Elle contient votre application et tout ce qu\'il faut pour la faire marcher</li>
            <li>Elle ne change jamais (lecture seule)</li>
            <li>Vous pouvez la partager avec d\'autres</li>
        </ul>
        
        <h3>📦 Conteneur Docker</h3>
        <p>Un <strong>conteneur</strong> c\'est votre application qui tourne :</p>
        <ul>
            <li>C\'est une image qui s\'exécute</li>
            <li>Vous pouvez l\'arrêter, le redémarrer, le supprimer</li>
            <li>Chaque conteneur est indépendant</li>
        </ul>
        
        <h3>🏪 Docker Hub</h3>
        <p>C\'est comme un magasin d\'applications :</p>
        <ul>
            <li>Vous y trouvez des milliers d\'images prêtes</li>
            <li>Vous pouvez y publier vos propres images</li>
            <li>Tout est gratuit pour les images publiques</li>
        </ul>
        
        <div class="alert alert-success">
            <strong>Analogie simple :</strong><br>
            📋 Image = Recette de cuisine<br>
            🍰 Conteneur = Le gâteau que vous cuisinez<br>
            🏪 Docker Hub = Livre de recettes partagé
        </div>';
    }

    private function getInstallationContent()
    {
        return '
        <h2>Installer Docker</h2>
        
        <h3>Sur Windows</h3>
        <ol>
            <li>Allez sur <a href="https://docker.com" target="_blank">docker.com</a></li>
            <li>Téléchargez "Docker Desktop pour Windows"</li>
            <li>Lancez l\'installateur et suivez les instructions</li>
            <li>Redémarrez votre ordinateur</li>
        </ol>
        
        <h3>Sur Mac</h3>
        <ol>
            <li>Allez sur <a href="https://docker.com" target="_blank">docker.com</a></li>
            <li>Téléchargez "Docker Desktop pour Mac"</li>
            <li>Glissez Docker dans votre dossier Applications</li>
            <li>Lancez Docker depuis vos Applications</li>
        </ol>
        
        <h3>Vérifier que ça marche</h3>
        <p>Ouvrez un terminal et tapez :</p>
        <div class="bg-dark text-light p-3 rounded">
            <code>docker --version</code>
        </div>
        
        <p>Vous devriez voir quelque chose comme :</p>
        <div class="bg-light p-3 rounded border">
            Docker version 24.0.0, build 1234567
        </div>
        
        <div class="alert alert-warning">
            <strong>Problème ?</strong> Redémarrez votre ordinateur et réessayez.
        </div>';
    }

    private function getHelloWorldContent()
    {
        return '
        <h2>Votre premier conteneur</h2>
        
        <p>Maintenant on va tester Docker avec un exemple simple !</p>
        
        <h3>La commande magique</h3>
        <p>Ouvrez un terminal et tapez exactement ceci :</p>
        
        <div class="bg-dark text-light p-3 rounded mb-3">
            <code>docker run hello-world</code>
        </div>
        
        <h3>Que va-t-il se passer ?</h3>
        <ol>
            <li><strong>Docker cherche</strong> l\'image "hello-world" sur votre ordinateur</li>
            <li><strong>Pas trouvée ?</strong> Il la télécharge depuis internet</li>
            <li><strong>Docker crée</strong> un nouveau conteneur avec cette image</li>
            <li><strong>Le conteneur affiche</strong> un message de bienvenue</li>
            <li><strong>Le conteneur s\'arrête</strong> automatiquement</li>
        </ol>
        
        <h3>Résultat attendu</h3>
        <div class="bg-light p-3 rounded border">
            Hello from Docker!<br>
            This message shows that your installation appears to be working correctly.
        </div>
        
        <h3>Félicitations ! 🎉</h3>
        <p>Si vous voyez ce message, Docker fonctionne parfaitement sur votre machine !</p>
        
        <div class="alert alert-success">
            <strong>Prochaine étape :</strong> Dans le chapitre suivant, nous verrons comment créer vos propres conteneurs.
        </div>';
    }
}
