<?php


namespace App\Core;

class App
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(string $requestUri): void
    {
        try {
            $this->router->handle($requestUri);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo "Internal Server Error: " . $e->getMessage();
        }
    }
}


//
//namespace App\Core;
//
//use App\Core\Router;
//
//class App
//{
//    private Router $router;
//
//    public function __construct(Router $router)
//    {
//        $this->router = $router;
//    }
//
//    public function run(string $requestUri): void
//    {
//        try {
//            $this->router->handle($requestUri);
//        } catch (\Throwable $e) {
//            http_response_code(500);
//            echo "Internal Server Error: " . $e->getMessage();
//        }
//    }
//}
//
//
