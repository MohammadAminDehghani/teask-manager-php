<?php

namespace App\migrations;

use App\Core\Migration;

class UsersMigration extends Migration
{
    public function up(): void
    {
        $this->connection->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ");
    }

    public function down(): void
    {
        $this->connection->exec("DROP TABLE IF EXISTS users;");
    }
}
