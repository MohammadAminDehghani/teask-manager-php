<?php


namespace App\Console;

use App\Core\Container;
use App\Core\MigrationRunner;

class ConsoleKernel
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(array $arguments): void
    {
        if (!isset($arguments[1])) {
            echo "No command provided.\n";
            return;
        }

        $command = $arguments[1];

        switch ($command) {
            case 'migrate':
                $this->runMigrations();
                break;

            case 'rollback':
                $this->rollbackMigrations();
                break;

            default:
                echo "Unknown command: {$command}\n";
        }
    }

    protected function runMigrations(): void
    {
        $runner = $this->container->get(MigrationRunner::class);
        $runner->runMigrations();
        echo "Migrations completed.\n";
    }

    protected function rollbackMigrations(): void
    {
        $runner = $this->container->get(MigrationRunner::class);
        $runner->rollbackLastMigration();
        echo "Rollback completed.\n";
    }
}
