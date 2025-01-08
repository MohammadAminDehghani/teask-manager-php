<?php


namespace App\Core;

class Request
{
    private array $query;
    private array $body;
    private array $server;

    public function __construct(array $query = [], array $body = [], array $server = [])
    {
        $this->query = $query;
        $this->body = $body;
        $this->server = $server;
    }

    public static function capture(): self
    {
        return new self($_GET, $_POST, $_SERVER);
    }

    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }

    public function input(string $key, $default = null)
    {
        $allInputs = $this->all();
        return $allInputs[$key] ?? $default;
    }

    public function get(string $key, $default = null)
    {
        return $this->query[$key] ?? $this->body[$key] ?? $default;
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function path(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $scriptName = dirname($this->server['SCRIPT_NAME']);
        return '/' . trim(str_replace($scriptName, '', parse_url($uri, PHP_URL_PATH)), '/');
    }

    public function headers(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerName = str_replace('_', '-', substr($key, 5));
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }

    public function header(string $key, $default = null)
    {
        $headers = $this->headers();
        $key = strtoupper(str_replace('-', '_', $key));
        return $headers[$key] ?? $default;
    }
}


//namespace App\Core;
//
//class Request
//{
//    private array $query;
//    private array $body;
//    private array $server;
//
//    public function __construct(array $query = [], array $body = [], array $server = [])
//    {
//        $this->query = $query;
//        $this->body = $body;
//        $this->server = $server;
//    }
//
//    public static function capture(): self
//    {
//        return new self($_GET, $_POST, $_SERVER);
//    }
//
//    public function all(): array
//    {
//        return array_merge($this->query, $this->body);
//    }
//
//    public function input(string $key, $default = null)
//    {
//        $allInputs = $this->all();
//        return $allInputs[$key] ?? $default;
//    }
//
//
//    public function get(string $key, $default = null)
//    {
//        return $this->query[$key] ?? $this->body[$key] ?? $default;
//    }
//
//    public function method(): string
//    {
//        return $this->server['REQUEST_METHOD'] ?? 'GET';
//    }
//
//    public function path(): string
//    {
//        $uri = $this->server['REQUEST_URI'] ?? '/';
//        $scriptName = dirname($this->server['SCRIPT_NAME']);
//        return '/' . trim(str_replace($scriptName, '', parse_url($uri, PHP_URL_PATH)), '/');
//    }
//}
