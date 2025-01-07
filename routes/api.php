<?php


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
];
