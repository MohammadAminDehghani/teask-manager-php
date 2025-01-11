<?php

use App\Core\Container;
use JetBrains\PhpStorm\NoReturn;

/**
 * Automatically registers controllers in the container.
 *
 * @param Container $container
 * @param string $namespace
 * @return void
 */
function registerControllers(Container $container, string $namespace): void
{
    $directory = __DIR__ . '/../../' . str_replace('\\', '/', $namespace);
    foreach (scandir($directory) as $file) {
        if ($file === '.' || $file === '..') continue;

        $className = $namespace . '\\' . pathinfo($file, PATHINFO_FILENAME);

        if (class_exists($className)) {
            $container->set($className, fn() => new $className());
        }
    }
}

/**
 * Automatically registers middleware in the container.
 *
 * @param Container $container
 * @param string $namespace
 * @return void
 */
function registerMiddleware(Container $container, string $namespace): void
{
    $directory = __DIR__ . '/../../' . str_replace('\\', '/', $namespace);
    foreach (scandir($directory) as $file) {
        if ($file === '.' || $file === '..') continue;

        $className = $namespace . '\\' . pathinfo($file, PATHINFO_FILENAME);
        if (class_exists($className)) {
            $container->set($className, fn() => new $className());
        }
    }
}

/**
 * Dump data in a readable format.
 *
 * @param mixed $data
 * @return void
 */
function dump(...$data): void
{
    echo '<pre style="background: #f4f4f4; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">';
    foreach ($data as $item) {
        print_r($item);
    }
    echo '</pre>';
}

/**
 * Dump data and stop execution.
 *
 * @param mixed $data
 * @return void
 */
#[NoReturn] function dd(...$data): void
{
    dump(...$data);
    die();
}

