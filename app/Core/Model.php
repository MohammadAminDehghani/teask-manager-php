<?php

namespace App\Core;

use PDO;

class Model
{
    //protected string $table;
    protected PDO $connection;

    protected string $table;

    /**
     * Get the table name for the model.
     */
    public static function getTable(): string
    {
        return static::$table ?? strtolower((new \ReflectionClass())->getShortName()) . 's';
    }

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

//    public function all(): array
//    {
//        $stmt = $this->connection->query("SELECT * FROM {$this->table}");
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }

//    public function find($id): ?array
//    {
//        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = :id");
//        $stmt->execute(['id' => $id]);
//        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
//    }

    public function create(array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($key) => ":$key", array_keys($data)));
        $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    /**
     * Get records matching conditions.
     */
    public function where(string $column, $value)
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function update($id, array $data): bool
    {
        $setClause = implode(',', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;

        $stmt = $this->connection->prepare("UPDATE {$this->table} SET $setClause WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete($id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Get all records.
     */
    public function all(): array
    {
        $stmt = $this->connection->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_CLASS, );
    }

    /**
     * Find a record by its primary key.
     */
    public function find(int | string $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        return $stmt->fetchObject();
    }

    /**
     * Get the first record matching the conditions.
     */
    public function first(array $conditions = [])
    {
        $query = self::buildQuery($conditions, 'LIMIT 1');
        $stmt = $this->connection->prepare($query['sql']);
        $stmt->execute($query['bindings']);

        return $stmt->fetchObject();
    }

    /**
     * Get the last record matching the conditions.
     */
    public function last(array $conditions = [])
    {
        $query = self::buildQuery($conditions, 'ORDER BY id DESC LIMIT 1');
        $stmt = $this->connection->prepare($query['sql']);
        $stmt->execute($query['bindings']);

        return $stmt->fetchObject();
    }

    /**
     * Get the latest record by a specific column.
     */
    public function latest(string $column = 'created_at', array $conditions = [])
    {
        $query = self::buildQuery($conditions, "ORDER BY {$column} DESC LIMIT 1");
        $stmt = $this->connection->prepare($query['sql']);
        $stmt->execute($query['bindings']);

        return $stmt->fetchObject();
    }

    /**
     * Helper to build dynamic queries.
     */
    private function buildQuery(array $conditions, string $suffix = ''): array
    {

        $sql = "SELECT * FROM {$this->table}";
        $bindings = [];

        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $column => $value) {
                $whereClauses[] = "{$column} = :{$column}";
                $bindings[$column] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $sql .= " {$suffix}";

        return ['sql' => $sql, 'bindings' => $bindings];
    }

}

