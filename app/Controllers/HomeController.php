<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

class HomeController {
    public function index(Request $req, Response $res) {
        //var_dump($req->get('name'));
        return $res->json([
            'data' => 'Welcome to home page!!123'
        ]);
        echo "Welcome to the home page!11";
    }
}

