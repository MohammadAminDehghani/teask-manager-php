<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
$base_url = "/pure-php/public";
return [
    [
        'method' => 'GET',
        'pattern' => $base_url.'/',
        'action' => [HomeController::class, 'index'],
    ],
    [
        'method' => 'GET',
        'pattern' => $base_url.'/user/{id}',
        'action' => [UserController::class, 'show'],
    ],
];

