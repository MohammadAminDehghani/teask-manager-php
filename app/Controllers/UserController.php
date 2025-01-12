<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Request;
use App\Core\Response;
use App\Models\User;

class UserController
{

    public function index(Request $request, Response $response): void
    {
        $userModel = new User();
        $users = $userModel->all();
        $response->json($users);
    }
    public function show(Request $request, Response $response, $id = null)
    {

        $userModel = new User();
        $user = $userModel->find($id);

        if ($user) {
            $user = json_decode(json_encode($user), true);
            $response->json($user);
        } else {
            $response->setStatusCode(404)->json(['error' => 'User not found']);
        }
    }


    public function store(Request $request, Response $response)
    {
        $user = new User();

        try {
            $user->create([
                'name' => 'akbar',
                'password' => 123,
                'email' => 'akbar@a.com',
            ]);

            return $response->json(['success' => 'User created']);

        }catch (\Exception $e){
            return $response->setStatusCode(500)->json(['error' => $e->getMessage()]);
        }

    }


}


