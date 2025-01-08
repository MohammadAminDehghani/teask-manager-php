<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

class UserController
{
    public function show(Request $request, Response $response, $id = null)
    {
        //dump($response);
        $name = $request->get('name');
        return $response->json([
            'id' => $id,
            'family' => $request->input('family'),
            'parameters' => $request->all()
        ]);

        //dump($response);
        echo "User ID: ".$id;
    }


    public function store(Request $request, $id = null)
    {
        //dump($request);
        //$name = $request->get('name');
        return Response::json([
            'id' => $id,
            'age' => $request->input('age'),
            'parameters' => $request->all()
        ]);

        //dump($response);
        //echo "User ID: ".$id;
    }
}


