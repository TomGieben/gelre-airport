<?php

namespace App\Helpers;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;
    private PDO $pdo;

    /**
     * Database constructor.
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    /**
     * Create a new instance of the Database class.
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * 
     * @return Database
     */
    public static function config(string $host, string $username, string $password, string $database): self
    {
        return new self($host, $username, $password, $database);
    }

    /**
     * Connect to the database.
     * 
     * @return void
     * 
     * @throws Exception
     */
    private function connect(): void
    {
        $dsn = "sqlsrv:Server={$this->host};Database={$this->database};ConnectionPooling=0;TrustServerCertificate=1";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Execute a query with the specified SQL and parameters.
     * 
     * @param string $sql
     * @param array $params
     * 
     * @return PDOStatement|false
     */
    public function query(string $sql, array $params = []): PDOStatement|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Get the last inserted ID.
     * 
     * @return string
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
