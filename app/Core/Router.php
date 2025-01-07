<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = array_map([$this, 'convertPattern'], $routes);
    }

    private function convertPattern(array $route): array
    {
        // Replace placeholders like {id} with regex patterns
        $route['pattern'] = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[^/]+)', $route['pattern']);
        $route['pattern'] = '/^' . str_replace('/', '\/', $route['pattern']) . '$/';
        return $route;
    }

    public function handle(string $requestUri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($requestUri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);


                // Instantiate the controller
                [$controllerClass, $method] = $route['action'];
                $controller = new $controllerClass();

                // Call the method on the controller instance
                call_user_func_array([$controller, $method], $params);

                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }



public function addRoute(string $method, string $path, callable $action): void
    {
        // Convert placeholders like {id} to named capture groups in regex
        $pattern = preg_replace('/{(\w+)}/', '(?P<$1>[^/]+)', $path);

        // Add delimiters to the regex pattern
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action,
        ];
    }
}


//
//namespace App\Core;
//
//class Router
//{
//    private array $routes;
//
//    public function __construct(array $routes)
//    {
//        $this->routes = $routes;
//    }
//
//    public function handle(string $requestUri)
//    {
//        $uri = parse_url($requestUri, PHP_URL_PATH);
//
//        foreach ($this->routes as $route => $action) {
//
//
//            $pattern = $this->convertRouteToRegex($route);
//
//            if (preg_match($pattern, $uri, $matches)) {
//                array_shift($matches); // Remove the full match
//                return $this->dispatch($action, $matches);
//            }
//        }
//
//        http_response_code(404);
//        echo "404 Not Found";
//    }
//
//    private function convertRouteToRegex(string $route): string
//    {
//        return '@^' . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route) . '$@';
//    }
//
//    private function dispatch($action, array $parameters): void
//    {
//        [$controller, $method] = $action;
//
//        if (!class_exists($controller)) {
//            throw new \Exception("Controller $controller not found");
//        }
//
//        $controllerInstance = new $controller();
//
//        if (!method_exists($controllerInstance, $method)) {
//            throw new \Exception("Method $method not found in $controller");
//        }
//        dump($parameters);
//        $parameters = array_values($parameters);
//        dump($parameters);
//        $controllerInstance->$method(...$parameters);
//    }
//}
