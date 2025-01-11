<?php


namespace App\Core;

use Exception;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(array $config): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "{$config['driver']}:host={$config['host']};dbname={$config['database']}",
                    $config['username'],
                    $config['password'],
                    $config['options'] ?? []
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            throw new Exception("Database not connected. Call Database::connect() first.");
        }

        return self::$connection;
    }
}
