<?php

namespace App\Controllers;

class HomeController {
    public function index(array $parameters = null): void {
        echo "Welcome to the home page!";
    }
}

