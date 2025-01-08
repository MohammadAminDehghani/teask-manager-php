<?php

namespace App\Core;

abstract class Middleware
{
    abstract public function handle(Request $request, Response $response, callable $next): void;
}
//interface Middleware
//{
//    public function handle():void;
//}