<?php


namespace App\Core;

use PDO;
use ReflectionClass;

class Model
{
    protected PDO $connection;
    protected string $table;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->table = $this->getTableName();
    }

    /**
     * Automatically determine the table name based on the class name.
     */
    protected function getTableName(): string
    {
        return $this->table ?? strtolower((new ReflectionClass($this))->getShortName()) . 's';
    }

    /**
     * Create a new record in the database.
     */
    public function create(array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($key) => ":$key", array_keys($data)));
        $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    /**
     * Retrieve records matching a condition and return model instances.
     */
    public function where(string $column, $value): ?self
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->mapToModel($result) : null;
    }

    /**
     * Update a record by its primary key.
     */
    public function update($id, array $data): bool
    {
        $setClause = implode(',', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;
        $stmt = $this->connection->prepare("UPDATE {$this->table} SET $setClause WHERE id = :id");
        return $stmt->execute($data);
    }

    /**
     * Delete a record by its primary key.
     */
    public function delete($id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Retrieve all records as model instances.
     */
    public function all(): array
    {
        $stmt = $this->connection->query("SELECT * FROM {$this->table}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToModel'], $results);
    }

    /**
     * Find a record by its primary key and return as a model instance.
     */
    public function find($id): ?self
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->mapToModel($result) : null;
    }

    /**
     * Map an associative array to the model instance.
     */
    private function mapToModel(array $data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }
}