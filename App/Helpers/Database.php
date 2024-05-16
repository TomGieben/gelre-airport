<?php

namespace App\Helpers;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Database {
    private string $host;
    private string $username;
    private string$password;
    private string $database;
    private PDO $pdo;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    public static function config(string $host, string $username, string $password, string $database): self
    {
        return new self($host, $username, $password, $database);
    }

    private function connect(): void
    {
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = []): PDOStatement|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
