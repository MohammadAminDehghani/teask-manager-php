<?php


namespace App\Core;

use PDO;

abstract class Migration
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    abstract public function up(): void;

    abstract public function down(): void;
}
