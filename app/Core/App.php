<?php


namespace App\Core;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function run(string $requestUri): void
    {
        try {
            $this->router->handle($requestUri, $this->container);
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
