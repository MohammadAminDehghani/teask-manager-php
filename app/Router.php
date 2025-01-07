<?php

namespace App;

use App\Core\Router;

// Create a new instance of the Router
//$router = new Router();
//
//// Define your routes
//$router->addRoute('GET', '/pure-php/public/', [\App\Controllers\HomeController::class, 'index']);
//$router->addRoute('GET', '/pure-php/public/user/{id}', [\App\Controllers\UserController::class, 'show']);
//
//// Return the router
//return $router;

//use App\Controllers\AuthController;
//use App\Controllers\HomeController;
//use App\Controllers\UserController;
//
//$base_dir = '/pure-php/public';
//$home_controller = new HomeController();
//$auth_controller = new AuthController();
////$user_controller = new UserController();
//
//return [
////    $base_dir . "/" => [],
//    $base_dir . "/" => [HomeController::class, 'index'],
//    $base_dir . "/login" => [$auth_controller, 'login'],
//    $base_dir . "/register" => [$auth_controller, 'register'],
//    $base_dir .'/user/{id}' => [UserController::class, 'show'], // Dynamic route
//];