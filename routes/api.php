<?php


use App\Controllers\Api\v1\AuthController;
use App\Controllers\UserController;

return [
    [
        'method' => 'GET',
        'pattern' => '/api/users',
        'action' => [UserController::class, 'index'],
    ],
    [
        'method' => 'GET',
        'pattern' => '/api/users/{id}',
        'action' => [UserController::class, 'show'],
    ],

    [
        'method' => 'POST',
        'pattern' => '/api/v1/auth/register',
        'action' => [AuthController::class, 'register'],
        'middleware' => [],
    ],

    [
        'method' => 'POST',
        'pattern' => '/api/v1/auth/login',
        'action' => [AuthController::class, 'login'],
        'middleware' => [],
    ],
];
