<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

return [
    [
        'method' => 'GET',
        'pattern' => '/',
        'action' => [HomeController::class, 'index'],
    ],
    [
        'method' => 'GET',
        'pattern' => '/user',
        'action' => [UserController::class, 'index'],
//        'middleware' => [AuthMiddleware::class],
    ],
    [
        'method' => 'GET',
        'pattern' => '/user/{id}',
        'action' => [UserController::class, 'show'],
    ],
    [
        'method' => 'POST',
        'pattern' => '/user/store',
        'action' => [UserController::class, 'store'],
        'middleware' => [],
    ],
];

