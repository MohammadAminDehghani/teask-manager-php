<?php

namespace App\Providers;

class RouteServiceProvider
{
    protected array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function loadRoutes(): array
    {
        return array_merge(...array_map(fn($file) => require $file, $this->routes));
    }
}
