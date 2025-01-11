<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$base_url = "/pure-php/public";
return [
    [
        'method' => 'GET',
        'pattern' => $base_url.'/',
        'action' => [HomeController::class, 'index'],
        'middleware' => [],
    ],
    [
        'method' => 'GET',
        'pattern' => $base_url.'/user',
        'action' => [UserController::class, 'index'],
        'middleware' => [],
//        'middleware' => [AuthMiddleware::class],
    ],
    [
        'method' => 'GET',
        'pattern' => $base_url.'/user/{id}',
        'action' => [UserController::class, 'show'],
        'middleware' => [],
//        'middleware' => [AuthMiddleware::class],
    ],
    [
        'method' => 'POST',
        'pattern' => $base_url.'/user/store',
        'action' => [UserController::class, 'store'],
        'middleware' => [],
//        'middleware' => [AuthMiddleware::class],
    ],
];

