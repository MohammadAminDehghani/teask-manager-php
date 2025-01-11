<?php

namespace App\Core;

class Config
{
    protected static array $config = [];

    public static function load(string $filePath)
    {
        $file = __DIR__ . "/../../config/" . $filePath . ".php";

        if (file_exists($file)) {
            self::$config = array_merge(self::$config, require $file);
        } else {
            throw new \Exception("Configuration file not found: {$file}");
        }

        return self::$config;
    }

    public static function get(string $key, $default = null)
    {
        $keys = explode('.', $key);

        $value = self::$config;

        foreach ($keys as $k) {

            if (!isset($value[$k])) {
                return $default;
            }

            $final_value = $value[$k];
        }

        return $final_value;
    }

}

// Usage: Config::get('database.host');
