<?php

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $host = $_ENV['DB_HOST'] ?? 'db';
            $dbname = $_ENV['DB_NAME'] ?? 'tuto_docker';
            $username = $_ENV['DB_USER'] ?? 'user';
            $password = $_ENV['DB_PASSWORD'] ?? 'password';

            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
        } catch (PDOException $e) {
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
            throw new Exception("Impossible de se connecter à la base de données");
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de requête SQL : " . $e->getMessage());
            throw new Exception("Erreur lors de l'exécution de la requête");
        }
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    public function commit()
    {
        return $this->connection->commit();
    }

    public function rollback()
    {
        return $this->connection->rollback();
    }

    public function inTransaction()
    {
        return $this->connection->inTransaction();
    }

    // Empêcher le clonage
    private function __clone() {}

    // Empêcher la désérialisation
    public function __wakeup()
    {
        throw new Exception("Impossible de désérialiser un singleton");
    }
}
