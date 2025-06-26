<?php

class Statistics
{
    private $db;

    public function __construct()
    {
        try {
            $database = Database::getInstance();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            error_log("Erreur de connexion Statistics: " . $e->getMessage());
            $this->db = null;
        }
    }

    /**
     * Récupère toutes les statistiques pour la page d'accueil
     * @return array
     */
    public function getHomeStatistics()
    {
        if (!$this->db) {
            return $this->getDefaultStatistics();
        }

        try {
            $stats = [];

            // Nombre total d'étudiants inscrits (utilisateurs uniques dans enrollments)
            $stmt = $this->db->query("SELECT COUNT(DISTINCT user_id) as total_students FROM enrollments");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['totalStudents'] = $result['total_students'] ?? 0;

            // Nombre total de modules (courses actifs)
            $stmt = $this->db->query("SELECT COUNT(*) as total_courses FROM courses WHERE is_active = 1");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['totalCourses'] = $result['total_courses'] ?? 18;

            // Nombre total d'heures de formation
            $stmt = $this->db->query("SELECT SUM(duration_hours) as total_hours FROM courses WHERE is_active = 1");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['totalHours'] = $result['total_hours'] ?? 150;

            // Nombre de projets (cours avec "Projet" dans le titre ou niveau avancé)
            $stmt = $this->db->query("SELECT COUNT(*) as total_projects FROM courses WHERE is_active = 1 AND (title LIKE '%Projet%' OR level = 'avancé')");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['totalProjects'] = $result['total_projects'] ?? 3;

            // Nombre total d'inscriptions
            $stmt = $this->db->query("SELECT COUNT(*) as total_enrollments FROM enrollments");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['totalEnrollments'] = $result['total_enrollments'] ?? 0;

            // Cours le plus populaire
            $stmt = $this->db->query("
                SELECT c.title, COUNT(e.id) as enrollment_count 
                FROM courses c 
                LEFT JOIN enrollments e ON c.id = e.course_id 
                WHERE c.is_active = 1 
                GROUP BY c.id, c.title 
                ORDER BY enrollment_count DESC 
                LIMIT 1
            ");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['mostPopularCourse'] = $result['title'] ?? 'Module 1 : Introduction et concepts fondamentaux';
            $stats['mostPopularCourseEnrollments'] = $result['enrollment_count'] ?? 0;

            return $stats;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des statistiques: " . $e->getMessage());
            return $this->getDefaultStatistics();
        }
    }

    /**
     * Statistiques par défaut en cas d'erreur
     * @return array
     */
    private function getDefaultStatistics()
    {
        return [
            'totalStudents' => 0,
            'totalCourses' => 18,
            'totalHours' => 150,
            'totalProjects' => 3,
            'totalEnrollments' => 0,
            'mostPopularCourse' => 'Module 1 : Introduction et concepts fondamentaux',
            'mostPopularCourseEnrollments' => 0
        ];
    }

    /**
     * Formater l'affichage du nombre d'étudiants
     * @param int $count
     * @return string
     */
    public function formatStudentCount($count)
    {
        if ($count == 0) {
            return 'Rejoignez-nous !';
        } elseif ($count < 10) {
            return $count . ' pionniers';
        } elseif ($count < 100) {
            return $count . '+';
        } else {
            return number_format($count, 0, ',', ' ') . '+';
        }
    }

    /**
     * Formater le label du nombre d'étudiants
     * @param int $count
     * @return string
     */
    public function formatStudentLabel($count)
    {
        if ($count == 0) {
            return 'Soyez les premiers';
        } elseif ($count == 1) {
            return 'Étudiant inscrit';
        } else {
            return 'Étudiants inscrits';
        }
    }

    /**
     * Récupère les statistiques personnelles d'un utilisateur
     * @param int $userId
     * @return array
     */
    public function getUserStatistics($userId)
    {
        if (!$this->db) {
            return $this->getDefaultUserStatistics();
        }

        try {
            $stats = [];

            // Nombre de cours auxquels l'utilisateur est inscrit
            $stmt = $this->db->prepare("SELECT COUNT(*) as enrolled_courses FROM enrollments WHERE user_id = ?");
            $stmt->execute([$userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['enrolledCourses'] = $result['enrolled_courses'] ?? 0;

            // Nombre de cours terminés (progression = 100%)
            $stmt = $this->db->prepare("SELECT COUNT(*) as completed_courses FROM enrollments WHERE user_id = ? AND progress = 100.00");
            $stmt->execute([$userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['completedCourses'] = $result['completed_courses'] ?? 0;

            // Progression moyenne
            $stmt = $this->db->prepare("SELECT AVG(progress) as avg_progress FROM enrollments WHERE user_id = ?");
            $stmt->execute([$userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['averageProgress'] = round($result['avg_progress'] ?? 0, 1);

            // Temps total d'apprentissage estimé (basé sur les cours inscrits)
            $stmt = $this->db->prepare("
                SELECT SUM(c.duration_hours * (e.progress / 100)) as total_hours 
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                WHERE e.user_id = ?
            ");
            $stmt->execute([$userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['totalHours'] = round($result['total_hours'] ?? 0, 1);

            // Dernier cours consulté
            $stmt = $this->db->prepare("
                SELECT c.title, e.enrolled_at, e.progress 
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                WHERE e.user_id = ? 
                ORDER BY e.enrolled_at DESC 
                LIMIT 1
            ");
            $stmt->execute([$userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['lastCourse'] = $result['title'] ?? null;
            $stats['lastCourseProgress'] = $result['progress'] ?? 0;

            return $stats;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des statistiques utilisateur: " . $e->getMessage());
            return $this->getDefaultUserStatistics();
        }
    }

    /**
     * Statistiques utilisateur par défaut
     * @return array
     */
    private function getDefaultUserStatistics()
    {
        return [
            'enrolledCourses' => 0,
            'completedCourses' => 0,
            'averageProgress' => 0,
            'totalHours' => 0,
            'lastCourse' => null,
            'lastCourseProgress' => 0
        ];
    }
}
