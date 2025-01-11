<?php


use App\Controllers\Api\v1\AuthController;
use App\Controllers\UserController;
$base_url = "/pure-php/public";
return [
    [
        'method' => 'GET',
        'pattern' => $base_url.'/api/users',
        'action' => [UserController::class, 'index'],
    ],
    [
        'method' => 'GET',
        'pattern' => $base_url.'/api/users/{id}',
        'action' => [UserController::class, 'show'],
    ],

    [
        'method' => 'POST',
        'pattern' => $base_url.'/api/v1/auth/register',
        'action' => [AuthController::class, 'register'],
        'middleware' => [],
    ],

    [
        'method' => 'POST',
        'pattern' => $base_url.'/api/v1/auth/login',
        'action' => [AuthController::class, 'login'],
        'middleware' => [],
    ],
];
