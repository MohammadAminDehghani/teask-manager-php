<?php

namespace App\Core;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private string $content = '';

    public function setStatusCode(int $status): self
    {
        $this->statusCode = $status;
        return $this;
    }

    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function json(array $data): self
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->content = json_encode($data);
        return $this;
    }

    public function html(string $content): self
    {
        $this->headers['Content-Type'] = 'text/html';
        $this->content = $content;
        return $this;
    }

    public function send(): void
    {
        // Send the status code
        http_response_code($this->statusCode);

        // Send headers
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        // Send content
        echo $this->content;
    }
}
