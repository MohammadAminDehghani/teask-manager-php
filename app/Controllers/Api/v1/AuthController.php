<?php

namespace App\Controllers\Api\v1;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\User;

class AuthController {
    public function login(Request $request, Response $response): Response
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if(!$email || !$password){
            return $response->json(['error', 'email and password are required']);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $user = new User();

        $user->where('email', $email);

        if(!$user || password_verify($password, $user->password)){
            return $response->json(['error', 'Invalid credentials']);
        }

        Session::start();
        Session::set('user_id', $user->id);

        return $response->json(['success' => true]);
    }

    public function register(Request $request, Response $response): Response
    {

        $name = $request->input("name");
        $email = $request->input("email");
        $password = $request->input("password");

        if(!$name || !$email|| !$password) {
            return $response->json(["error" => "name, email and password are required!"]);
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = new User();

        $user->create([
            "name" => $name,
            "email" => $email,
            "password" => $password
        ]);

        return $response->json(["success" => true]);

    }
}