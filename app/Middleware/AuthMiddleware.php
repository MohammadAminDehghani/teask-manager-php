<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request, Response $response, callable $next): void
    {
        // Example: Check if user is authenticated
        $authHeader = $request->headers()['Authorization'] ?? null;

        if (!$authHeader || $authHeader !== 'Bearer valid-token') {
            $response->setStatusCode(401)->json(['error' => 'Unauthorized'])->send();
            return;
        }

        // Proceed to the next middleware or controller
        $next();
    }
}



//class AuthMiddleware implements Middleware
//{
//    public function handle(): void
//    {
//        if (empty($_SESSION['user'])) {
//            http_response_code(401);
//            echo "Unauthorized";
//            exit;
//        }
//    }
//}
