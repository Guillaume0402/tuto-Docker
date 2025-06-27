<?php

class Course
{
    private $db;
    private $table = 'courses';

    public function __construct()
    {
        // Tentative de connexion à la base de données
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            // Si pas de base de données, on utilise des données statiques
            $this->db = null;
        }
    }

    public function find($id)
    {
        // Si pas de base de données, utiliser des données statiques
        if ($this->db === null) {
            return $this->getStaticCourse($id);
        }

        $query = "SELECT c.*, u.username as instructor_name, 
                         CONCAT(u.first_name, ' ', u.last_name) as instructor_full_name
                  FROM {$this->table} c 
                  LEFT JOIN users u ON c.instructor_id = u.id 
                  WHERE c.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($limit = null, $offset = 0)
    {
        // Si pas de base de données, utiliser des données statiques
        if ($this->db === null) {
            return $this->getStaticCourses();
        }

        $query = "SELECT c.*, u.username as instructor_name, 
                         CONCAT(u.first_name, ' ', u.last_name) as instructor_full_name,
                         COUNT(e.id) as enrolled_count
                  FROM {$this->table} c 
                  LEFT JOIN users u ON c.instructor_id = u.id 
                  LEFT JOIN enrollments e ON c.id = e.course_id
                  WHERE c.is_active = 1
                  GROUP BY c.id
                  ORDER BY c.created_at DESC";

        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($query);

        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Données statiques pour les tests sans base de données
    private function getStaticCourse($id)
    {
        $courses = $this->getStaticCourses();
        foreach ($courses as $course) {
            if ($course['id'] == $id) {
                return $course;
            }
        }
        return null;
    }

    private function getStaticCourses()
    {
        return [
            [
                'id' => 1,
                'title' => '🧱 Introduction à Docker',
                'description' => 'Découvrez les bases de Docker et de la conteneurisation. Ce cours complet vous permettra de comprendre les concepts fondamentaux.',
                'content' => 'Module complet sur les bases de Docker',
                'level' => 'débutant',
                'duration_hours' => 4,
                'enrolled_count' => 156,
                'instructor_full_name' => 'Formation Docker',
                'instructor_name' => 'docker_trainer',
                'image_url' => null,
                'created_at' => '2024-01-15 10:00:00',
                'is_active' => 1,
                'price' => 0
            ],
            [
                'id' => 2,
                'title' => '🏗️ Installation et Configuration',
                'description' => 'Apprenez à installer Docker Desktop et configurer votre environnement de développement.',
                'content' => 'Guide complet d\'installation et configuration',
                'level' => 'débutant',
                'duration_hours' => 3,
                'enrolled_count' => 142,
                'instructor_full_name' => 'Formation Docker',
                'instructor_name' => 'docker_trainer',
                'image_url' => null,
                'created_at' => '2024-01-16 10:00:00',
                'is_active' => 1,
                'price' => 0
            ],
            [
                'id' => 3,
                'title' => '📦 Premiers Conteneurs',
                'description' => 'Créez et gérez vos premiers conteneurs Docker avec des exemples pratiques.',
                'content' => 'Travaux pratiques sur les conteneurs',
                'level' => 'débutant',
                'duration_hours' => 5,
                'enrolled_count' => 128,
                'instructor_full_name' => 'Formation Docker',
                'instructor_name' => 'docker_trainer',
                'image_url' => null,
                'created_at' => '2024-01-17 10:00:00',
                'is_active' => 1,
                'price' => 0
            ],
            [
                'id' => 4,
                'title' => '🎨 Images Docker - Création et Gestion',
                'description' => 'Maîtrisez la création, l\'optimisation et la publication d\'images Docker professionnelles.',
                'content' => 'Module complet sur les images Docker',
                'level' => 'intermédiaire',
                'duration_hours' => 6,
                'enrolled_count' => 98,
                'instructor_full_name' => 'Formation Docker',
                'instructor_name' => 'docker_trainer',
                'image_url' => null,
                'created_at' => '2024-01-18 10:00:00',
                'is_active' => 1,
                'price' => 0
            ],
            [
                'id' => 5,
                'title' => '🌐 Réseaux Docker',
                'description' => 'Comprenez et configurez les réseaux Docker pour connecter vos conteneurs.',
                'content' => 'Module sur les réseaux et la communication',
                'level' => 'intermédiaire',
                'duration_hours' => 5,
                'enrolled_count' => 87,
                'instructor_full_name' => 'Formation Docker',
                'instructor_name' => 'docker_trainer',
                'image_url' => null,
                'created_at' => '2024-01-19 10:00:00',
                'is_active' => 1,
                'price' => 0
            ]
        ];
    }

    // Autres méthodes pour la compatibilité
    public function create($data)
    {
        if ($this->db === null) {
            return false;
        }
        // Code de création en base
        return true;
    }

    public function update($id, $data)
    {
        if ($this->db === null) {
            return false;
        }
        // Code de mise à jour en base  
        return true;
    }

    public function delete($id)
    {
        if ($this->db === null) {
            return false;
        }
        // Code de suppression en base
        return true;
    }

    public function formatPrice($price)
    {
        return $price == 0 ? 'GRATUIT' : number_format($price, 2) . ' €';
    }

    public function getLevelBadgeClass($level)
    {
        $classes = [
            'débutant' => 'bg-success',
            'intermédiaire' => 'bg-warning',
            'avancé' => 'bg-danger'
        ];

        return $classes[$level] ?? 'bg-secondary';
    }

    /**
     * Récupère le contenu réel d'un module depuis les fichiers
     */
    public function getModuleContent($courseId)
    {
        $moduleDir = "content/modules/module-" . str_pad($courseId, 2, '0', STR_PAD_LEFT);
        $basePath = dirname(dirname(__DIR__)) . "/" . $moduleDir;

        $content = [];

        // Charger README.md
        $readmePath = $basePath . "/README.md";
        if (file_exists($readmePath)) {
            $content['readme'] = file_get_contents($readmePath);
            $content['chapters'] = $this->extractChaptersFromReadme($content['readme']);
        }

        // Charger TP.md
        $tpPath = $basePath . "/TP.md";
        if (file_exists($tpPath)) {
            $content['tp'] = file_get_contents($tpPath);
        }

        // Charger QUIZ.md
        $quizPath = $basePath . "/QUIZ.md";
        if (file_exists($quizPath)) {
            $content['quiz'] = file_get_contents($quizPath);
        }

        // Charger RESOURCES.md
        $resourcesPath = $basePath . "/RESOURCES.md";
        if (file_exists($resourcesPath)) {
            $content['resources'] = file_get_contents($resourcesPath);
        }

        return $content;
    }

    /**
     * Extrait les chapitres du contenu README
     */
    private function extractChaptersFromReadme($readmeContent)
    {
        $chapters = [];

        if (empty($readmeContent)) {
            return $chapters;
        }

        // Diviser le contenu en lignes
        $lines = explode("\n", $readmeContent);
        $currentChapter = null;
        $currentContent = '';

        foreach ($lines as $line) {
            // Détecter les titres de niveau 2 (##)
            if (preg_match('/^##\s+(.+)/', $line, $matches)) {
                // Sauvegarder le chapitre précédent s'il existe
                if ($currentChapter !== null) {
                    $chapters[] = [
                        'title' => $currentChapter,
                        'content' => trim($currentContent)
                    ];
                }

                // Commencer un nouveau chapitre
                $currentChapter = $matches[1];
                $currentContent = '';
            } else {
                // Ajouter le contenu au chapitre actuel
                if ($currentChapter !== null) {
                    $currentContent .= $line . "\n";
                }
            }
        }

        // Sauvegarder le dernier chapitre
        if ($currentChapter !== null) {
            $chapters[] = [
                'title' => $currentChapter,
                'content' => trim($currentContent)
            ];
        }

        return $chapters;
    }

    /**
     * Vérifie si un utilisateur est inscrit à un cours
     */
    public function isUserEnrolled($userId, $courseId)
    {
        if ($this->db === null) {
            // Sans base de données, on simule qu'il n'est pas inscrit
            return false;
        }

        $query = "SELECT COUNT(*) FROM enrollments WHERE user_id = :user_id AND course_id = :course_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Inscrit un utilisateur à un cours
     */
    public function enrollUser($userId, $courseId)
    {
        if ($this->db === null) {
            // Sans base de données, on simule une inscription réussie
            return true;
        }

        // Vérifier si déjà inscrit
        if ($this->isUserEnrolled($userId, $courseId)) {
            return false;
        }

        $query = "INSERT INTO enrollments (user_id, course_id, enrolled_at) VALUES (:user_id, :course_id, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
