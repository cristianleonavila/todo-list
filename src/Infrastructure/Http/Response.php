<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

class Response
{
    public function __construct(
        private mixed $data,
        private int $statusCode = 200,
        private array $headers = []
    ) {
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        header('Content-Type: application/json');

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo json_encode($this->data);
    }
}