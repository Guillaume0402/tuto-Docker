<?php

class Message
{
    private $db;
    private $table = 'messages';

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

    public function findAll($limit = null, $offset = 0, $unreadOnly = false)
    {
        $query = "SELECT * FROM {$this->table}";

        if ($unreadOnly) {
            $query .= " WHERE is_read = 0";
        }

        $query .= " ORDER BY created_at DESC";

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

    public function create($data)
    {
        $query = "INSERT INTO {$this->table} (name, email, subject, message) 
                  VALUES (:name, :email, :subject, :message)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':subject', $data['subject']);
        $stmt->bindParam(':message', $data['message']);

        return $stmt->execute();
    }

    public function markAsRead($id)
    {
        $query = "UPDATE {$this->table} SET is_read = 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function markAsUnread($id)
    {
        $query = "UPDATE {$this->table} SET is_read = 0 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function getUnreadCount()
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE is_read = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function getMessagesByEmail($email)
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function formatDate($dateString)
    {
        $date = new DateTime($dateString);
        return $date->format('d/m/Y à H:i');
    }

    public function getExcerpt($message, $length = 100)
    {
        if (strlen($message) <= $length) {
            return $message;
        }

        return substr($message, 0, $length) . '...';
    }
}
