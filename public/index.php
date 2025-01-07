<?php


// Display errors for development (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload classes using PSR-4
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/functions.php';

use App\Core\App;
use App\Core\Router;

// Load routes
$webRoutes = include __DIR__ . '/../routes/web.php';
$apiRoutes = include __DIR__ . '/../routes/api.php';

// Merge all routes
$routes = array_merge($webRoutes, $apiRoutes);

// Initialize the Router
$router = new Router($routes);

// Initialize the App with the Router
$app = new App($router);

// Run the application
$app->run($_SERVER['REQUEST_URI']);


// Display errors for development (disable in production)
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/../app/Core/App.php';
//require_once __DIR__ . '/../app/Helpers/functions.php';
//
//
//
//use App\Core\App;
//use App\Core\Router;
//
//$routes = include_once __DIR__ . '/../app/Router.php';
//$router = new Router($routes);
//
//$app = new App($router);
//$app->run($_SERVER['REQUEST_URI']);


