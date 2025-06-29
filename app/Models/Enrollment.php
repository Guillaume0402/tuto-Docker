<?php

class Enrollment
{
    private $db;
    private $table = 'enrollments';

    public function __construct()
    {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            $this->db = null;
        }
    }

    /**
     * Récupère les statistiques d'un utilisateur
     */
    public function getUserStats($userId)
    {
        if ($this->db === null) {
            // Données statiques pour les tests sans DB
            return [
                'total_enrolled' => 3,
                'completed_courses' => 1,
                'in_progress_courses' => 2,
                'total_hours' => 12
            ];
        }

        $query = "SELECT 
                    COUNT(*) as total_enrolled,
                    SUM(CASE WHEN progress = 100 THEN 1 ELSE 0 END) as completed_courses,
                    SUM(CASE WHEN progress > 0 AND progress < 100 THEN 1 ELSE 0 END) as in_progress_courses,
                    COALESCE(SUM(c.duration_hours), 0) as total_hours
                  FROM {$this->table} e
                  LEFT JOIN courses c ON e.course_id = c.id
                  WHERE e.user_id = :user_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les cours d'un utilisateur avec progression
     */
    public function getUserCourses($userId, $limit = null)
    {
        if ($this->db === null) {
            // Données statiques pour les tests sans DB
            return [
                [
                    'id' => 1,
                    'title' => 'Introduction à Docker',
                    'progress' => 75,
                    'enrolled_at' => '2024-06-20 10:00:00',
                    'duration_hours' => 4,
                    'level' => 'débutant'
                ],
                [
                    'id' => 2,
                    'title' => 'PHP avec Docker',
                    'progress' => 45,
                    'enrolled_at' => '2024-06-21 14:30:00',
                    'duration_hours' => 6,
                    'level' => 'intermédiaire'
                ],
                [
                    'id' => 4,
                    'title' => 'Images Docker',
                    'progress' => 100,
                    'enrolled_at' => '2024-06-15 09:15:00',
                    'duration_hours' => 5,
                    'level' => 'intermédiaire'
                ]
            ];
        }

        $query = "SELECT 
                    c.id,
                    c.title,
                    c.level,
                    c.duration_hours,
                    e.progress,
                    e.enrolled_at,
                    e.completed_at
                  FROM {$this->table} e
                  JOIN courses c ON e.course_id = c.id
                  WHERE e.user_id = :user_id
                  ORDER BY e.enrolled_at DESC";

        if ($limit) {
            $query .= " LIMIT :limit";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère l'activité récente d'un utilisateur
     */
    public function getRecentActivity($userId, $limit = 5)
    {
        if ($this->db === null) {
            // Données statiques pour les tests
            return [
                [
                    'type' => 'course_completed',
                    'title' => 'Introduction à Docker - Chapitre 1',
                    'created_at' => '2024-06-26 10:30:00'
                ],
                [
                    'type' => 'lesson_started',
                    'title' => 'PHP avec Docker - Configuration',
                    'created_at' => '2024-06-25 14:15:00'
                ],
                [
                    'type' => 'badge_earned',
                    'title' => 'Premiers pas avec Docker',
                    'created_at' => '2024-06-24 16:45:00'
                ],
                [
                    'type' => 'enrollment',
                    'title' => 'Docker en production',
                    'created_at' => '2024-06-23 09:20:00'
                ]
            ];
        }

        // Pour l'instant, on simule l'activité récente
        // Dans une vraie app, on aurait une table activity_log
        $query = "SELECT 
                    'enrollment' as type,
                    CONCAT('Inscription : ', c.title) as title,
                    e.enrolled_at as created_at
                  FROM {$this->table} e
                  JOIN courses c ON e.course_id = c.id
                  WHERE e.user_id = :user_id
                  ORDER BY e.enrolled_at DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inscrire un utilisateur à un cours
     */
    public function enrollUser($userId, $courseId)
    {
        if ($this->db === null) {
            return false;
        }

        $query = "INSERT INTO {$this->table} (user_id, course_id) VALUES (:user_id, :course_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Vérifier si un utilisateur est inscrit à un cours
     */
    public function isUserEnrolled($userId, $courseId)
    {
        if ($this->db === null) {
            return false;
        }

        $query = "SELECT COUNT(*) FROM {$this->table} WHERE user_id = :user_id AND course_id = :course_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Mettre à jour la progression d'un utilisateur
     */
    public function updateProgress($userId, $courseId, $progress)
    {
        if ($this->db === null) {
            return false;
        }

        $query = "UPDATE {$this->table} 
                  SET progress = :progress,
                      completed_at = CASE WHEN :progress2 = 100 THEN NOW() ELSE NULL END
                  WHERE user_id = :user_id AND course_id = :course_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':progress', $progress, PDO::PARAM_STR);
        $stmt->bindParam(':progress2', $progress, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Marque un chapitre comme terminé pour un utilisateur
     */
    public function markChapterComplete($userId, $courseId, $chapterNumber)
    {
        if ($this->db === null) {
            return false;
        }
        // Insère ou ignore si déjà existant
        $query = "INSERT IGNORE INTO chapter_progress (user_id, course_id, chapter_number, completed_at)
                  VALUES (:user_id, :course_id, :chapter_number, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->bindParam(':chapter_number', $chapterNumber, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Retourne le nombre de chapitres terminés pour un utilisateur dans un cours
     */
    public function getCompletedChapters($userId, $courseId)
    {
        if ($this->db === null) {
            return 0;
        }
        $query = "SELECT COUNT(*) FROM chapter_progress WHERE user_id = :user_id AND course_id = :course_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    /**
     * Calcule la progression réelle d'un utilisateur dans un cours (en %)
     * @param int $userId
     * @param int $courseId
     * @param int $totalChapters
     * @return float
     */
    public function getCourseProgress($userId, $courseId, $totalChapters)
    {
        if ($totalChapters <= 0) return 0;
        $completed = $this->getCompletedChapters($userId, $courseId);
        return round(($completed / $totalChapters) * 100, 2);
    }
}
