<?php

return [
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'pure',
    'username' => 'root',
    'password' => '',
    'options' => [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
];
