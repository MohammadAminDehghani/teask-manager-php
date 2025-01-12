<?php

use App\Core\App;
use App\Core\Config;
use App\Core\Container;
use App\Core\Database;
use App\Core\Router;
use App\Providers\RouteServiceProvider;
use App\Providers\SessionServiceProvider;
use App\Console\ConsoleKernel;

// Display errors for development (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload classes
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/functions.php';

// Load configurations
$config = Config::load('app');

// Initialize the container
$container = new Container();

// Register service providers
$container->set(SessionServiceProvider::class, function () {
    return new SessionServiceProvider();
});

$container->set(RouteServiceProvider::class, function () use ($config) {
    return new RouteServiceProvider($config['routes']);
});

$db_config = Config::load('database');
Database::connect($db_config);

// Automatic Controller Registration
registerControllers($container, 'App\Controllers');
registerControllers($container, 'App\Controllers\Api\v1');

// Automatic Middleware Registration
registerMiddleware($container, 'App\Middleware');

// Handle CLI commands
if (php_sapi_name() === 'cli') {
    $kernel = new ConsoleKernel($container);
    $kernel->handle($argv);
    exit;
}

// Start session
$sessionServiceProvider = $container->get(SessionServiceProvider::class);
$sessionServiceProvider->boot();

// Load routes
$routeServiceProvider = $container->get(RouteServiceProvider::class);
$routes = $routeServiceProvider->loadRoutes();

// Initialize the Router
$router = new Router($routes);

// Bootstrap the application
$app = new App($router,$container);

// Run the application
$app->run($_SERVER['REQUEST_URI']);