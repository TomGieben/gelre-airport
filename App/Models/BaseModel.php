<?php

namespace App\Models;

use App\Helpers\Database;

abstract class BaseModel
{
    protected string $table;
    protected array $primaryKey = ['id'];
    protected array $columns = [];
    protected Database $database;

    /**
     * BaseModel constructor.
     * 
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        error_reporting(E_ALL ^ E_DEPRECATED); // Disable deprecated errors

        global $database;

        $this->database = $database;

        foreach ($data as $key => $value) {
            if (in_array($key, $this->columns)) {
                $this->$key = $value;
            }
        }
    }

    /*
    * Query builder
    *
    * @return self
    */
    public static function query(): self
    {
        return new self();
    }

    /**
     * Get all models
     *
     * @return array
     */
    public function all(): array
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->database->query($sql);
        $rows = $stmt->fetchAll();
        $models = [];

        foreach ($rows as $row) {
            $models[] = new self($row);
        }

        return $models;
    }

    /**
     * Get all models with a where clause
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return array
     */
    public function raw(string $sql, array $params = []): array
    {
        $stmt = $this->database->query($sql, $params);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $models[] = new self($row);
        }

        return $models;
    }

    /**
     * Find a model by primary key
     *
     * @param array $primaryKeys
     * @return self|false
     */
    public function find(array $primaryKeys): self|false
    {
        $conditions = [];
        $params = [];

        foreach ($this->primaryKey as $key) {
            $conditions[] = "$key = ?";
            $params[] = $primaryKeys[$key];
        }

        $sql = "SELECT * FROM $this->table WHERE " . implode(' AND ', $conditions);
        $stmt = $this->database->query($sql, $params);
        $data = $stmt->fetch();

        if (!$data) {
            return false;
        }

        return new static($data);
    }

    /**
     * Create a new model
     *
     * @param array $data
     * @return self|false
     */
    public function create(array $data): self|false
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $stmt = $this->database->query($sql, array_values($data));

        if (!$stmt) {
            return false;
        }

        return $this->find($data);
    }

    /**
     * Update a model
     *
     * @param array $data
     * @return self|false
     */
    public function update(array $data): self|false
    {
        $columns = array_map(fn ($column) => "$column = ?", array_keys($data));
        $conditions = [];
        $params = [];

        foreach ($this->primaryKey as $key) {
            $conditions[] = "$key = ?";
            $params[] = $data[$key];
            unset($data[$key]);
        }

        $sql = "UPDATE $this->table SET " . implode(', ', $columns) . " WHERE " . implode(' AND ', $conditions);
        $stmt = $this->database->query($sql, [...array_values($data), ...$params]);

        if (!$stmt) {
            return false;
        }

        return $this->find($params);
    }

    /**
     * Delete a model
     *
     * @return bool
     */
    public function delete(): bool
    {
        $conditions = [];
        $params = [];

        foreach ($this->primaryKey as $key) {
            $conditions[] = "$key = ?";
            $params[] = $this->{$key};
        }

        $sql = "DELETE FROM $this->table WHERE " . implode(' AND ', $conditions);
        $stmt = $this->database->query($sql, $params);

        return (bool)$stmt;
    }
}
