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

    public function handle(string $requestUri, Container $container): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($requestUri, PHP_URL_PATH);

        $request = Request::capture();
        //$request->header('Authorization');
        $response = new Response();

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Handle middleware
                $middlewareStack = $this->buildMiddlewareStack($route['middleware'], $container);
                $this->processMiddlewareStack($middlewareStack, $request, $response, function () use ($route, $container, $request, $response, $params) {
                    if (is_array($route['action'])) {
                        [$controllerClass, $method] = $route['action'];

                        $controllerInstance = $container->get($controllerClass);
                        call_user_func_array([$controllerInstance, $method], [$request, $response, ...$params]);
                    } else {
                        call_user_func($route['action'], [$request, $response, ...$params]);
                    }

                    if ($response instanceof Response) {
                        $response->send();
                    } else {
                        echo $response;
                    }
                });

                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function buildMiddlewareStack(array $middlewareClasses, Container $container): array
    {
        $middlewareStack = [];
        foreach ($middlewareClasses as $middlewareClass) {
            $middlewareStack[] = $container->get($middlewareClass);
        }
        return $middlewareStack;
    }

    private function processMiddlewareStack(array $middlewareStack, Request $request, Response $response, callable $next): void
    {
        if (empty($middlewareStack)) {
            $next();
            return;
        }

        $currentMiddleware = array_shift($middlewareStack);
        $currentMiddleware->handle($request, $response, function () use ($middlewareStack, $request, $response, $next) {
            $this->processMiddlewareStack($middlewareStack, $request, $response, $next);
        });
    }


}