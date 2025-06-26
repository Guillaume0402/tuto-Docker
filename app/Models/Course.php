<?php

class Course
{
    private $db;
    private $table = 'courses';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function find($id)
    {
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

    public function findByLevel($level)
    {
        $query = "SELECT c.*, u.username as instructor_name, 
                         CONCAT(u.first_name, ' ', u.last_name) as instructor_full_name
                  FROM {$this->table} c 
                  LEFT JOIN users u ON c.instructor_id = u.id 
                  WHERE c.level = :level AND c.is_active = 1
                  ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':level', $level);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table} 
                  (title, description, content, instructor_id, price, duration_hours, level, image_url) 
                  VALUES (:title, :description, :content, :instructor_id, :price, :duration_hours, :level, :image_url)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':instructor_id', $data['instructor_id']);
        // Formation gratuite - prix toujours à 0
        $price = 0;
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':duration_hours', $data['duration_hours']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':image_url', $data['image_url'] ?? null);

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $fields[] = "{$key} = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        $query = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $query = "UPDATE {$this->table} SET is_active = 0 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function isUserEnrolled($userId, $courseId)
    {
        $query = "SELECT COUNT(*) FROM enrollments WHERE user_id = :user_id AND course_id = :course_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function enrollUser($userId, $courseId)
    {
        $query = "INSERT INTO enrollments (user_id, course_id) VALUES (:user_id, :course_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':course_id', $courseId);

        return $stmt->execute();
    }

    public function getEnrolledUsers($courseId)
    {
        $query = "SELECT u.*, e.enrolled_at, e.progress 
                  FROM users u 
                  INNER JOIN enrollments e ON u.id = e.user_id 
                  WHERE e.course_id = :course_id 
                  ORDER BY e.enrolled_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function formatPrice($price)
    {
        // Formation gratuite - retourne toujours "GRATUIT"
        return '<i class="fas fa-heart me-1"></i>GRATUIT';
    }

    public function getLevelBadgeClass($level)
    {
        switch ($level) {
            case 'débutant':
                return 'badge-info';
            case 'intermédiaire':
                return 'badge-warning';
            case 'avancé':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }
}
