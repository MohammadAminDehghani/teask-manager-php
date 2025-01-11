<?php

namespace App\Core;

use PDO;

class MigrationRunner
{
    public function runMigrations(): void
    {
        $migrations = $this->getMigrationFiles();
        $executedMigrations = $this->getExecutedMigrations();

        foreach ($migrations as $migration) {
            if (!in_array($migration, $executedMigrations)) {
                $this->runMigration($migration);
            }
        }
    }

    private function getMigrationFiles(): array
    {
        $files = glob(__DIR__ . '/../migrations/*.php');
        return array_map(fn($file) => basename($file, '.php'), $files);
    }

    private function getExecutedMigrations(): array
    {
        $stmt = Database::getConnection()->query("SELECT name FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function runMigration(string $migration): void
    {
        require_once __DIR__ . "/../migrations/{$migration}.php";
        $migrationClass = "App\\Migrations\\$migration";

        /** @var Migration $migrationInstance */
        $migrationInstance = new $migrationClass();
        $migrationInstance->up();

        $stmt = Database::getConnection()->prepare("INSERT INTO migrations (name) VALUES (:name)");
        $stmt->execute(['name' => $migration]);
        echo "Migration {$migration} executed successfully.\n";
    }

    public function rollbackLastMigration(): void
    {
        $stmt = Database::getConnection()->query("SELECT name FROM migrations ORDER BY id DESC LIMIT 1");
        $lastMigration = $stmt->fetchColumn();

        if ($lastMigration) {
            require_once __DIR__ . "/../migrations/{$lastMigration}.php";
            $migrationClass = "App\\Migrations\\$lastMigration";

            /** @var Migration $migrationInstance */
            $migrationInstance = new $migrationClass();
            $migrationInstance->down();

            Database::getConnection()->prepare("DELETE FROM migrations WHERE name = :name")
                ->execute(['name' => $lastMigration]);

            echo "Migration {$lastMigration} rolled back successfully.\n";
        } else {
            echo "No migrations to rollback.\n";
        }
    }

}
