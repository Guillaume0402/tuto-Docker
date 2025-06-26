<?php

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $query = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table} (username, email, password, first_name, last_name) 
                  VALUES (:username, :email, :password, :first_name, :last_name)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);

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
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function getEnrolledCourses($userId)
    {
        $query = "SELECT c.*, e.enrolled_at, e.progress 
                  FROM courses c 
                  INNER JOIN enrollments e ON c.id = e.course_id 
                  WHERE e.user_id = :user_id 
                  ORDER BY e.enrolled_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFullName($user)
    {
        if (is_array($user)) {
            return trim($user['first_name'] . ' ' . $user['last_name']);
        }
        return '';
    }
}
