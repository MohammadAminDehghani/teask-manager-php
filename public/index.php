<?php

//use App\Core\Router;
//use App\Core\App;
//use App\Middleware\AuthMiddleware;
//
//require_once __DIR__ . '/../vendor/autoload.php';
//
//$router = new Router($request);
//$router->addMiddleware(new AuthMiddleware());
//
//$app = new App($router);
//$app->run($_SERVER['REQUEST_URI']);


use App\Controllers\Api\v1\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\App;
use App\Core\Container;
use App\Core\Database;
use App\Core\MigrationRunner;
use App\Core\Router;
use App\Core\Session;
use App\Middleware\AuthMiddleware;

// Display errors for development (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload classes using PSR-4
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/functions.php';
// Load routes
$webRoutes = include __DIR__ . '/../routes/web.php';
$apiRoutes = include __DIR__ . '/../routes/api.php';
$configDB = include __DIR__ . '/../config/database.php';




Database::connect($configDB);

if (php_sapi_name() === 'cli' && isset($argv[1]) && $argv[1] === 'migrate') {
    $runner = new MigrationRunner();
    $runner->runMigrations();
    exit;
}

if (php_sapi_name() === 'cli' && isset($argv[1]) && $argv[1] === 'rollback') {
    $runner = new MigrationRunner();
    $runner->rollbackLastMigration();
    exit;
}



//session_start();
//$_SESSION['user'] = ['id' => 4, 'name' => 'Amin'];

// Start session
$session = new Session();
$session->start();


// Create the container
$container = new Container();

// Register controllers
$container->set(HomeController::class, function () {
    return new HomeController();
});

$container->set(UserController::class, function () {
    return new UserController();
});

$container->set(AuthController::class, function () {
    return new AuthController();
});



// Register middleware
$container->set(AuthMiddleware::class, function () {
    return new AuthMiddleware();
});


// Merge all routes
$routes = array_merge($webRoutes, $apiRoutes);

// Initialize the Router
$router = new Router($routes);

// Initialize the App with the Router
$app = new App($router, $container);

// Run the application
$app->run($_SERVER['REQUEST_URI']);



