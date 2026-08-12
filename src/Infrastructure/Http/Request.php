<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

class Request
{
    public function __construct(
        private string $method,
        private string $path,
        private array $queryParams,
        private array $body,
        private array $headers
    ) {
    }

    public static function fromGlobals(): self
    {
        $body = file_get_contents('php://input');

        $data = [];

        if ($body !== '') {
            $data = json_decode($body, true);

            if (!is_array($data)) {
                throw new \RuntimeException(
                    'Invalid JSON body'
                );
            }
        }

        return new self(
            method: $_SERVER['REQUEST_METHOD'],
            path: parse_url(
                $_SERVER['REQUEST_URI'],
                PHP_URL_PATH
            ),
            queryParams: $_GET,
            body: $data,
            headers: getallheaders()
        );
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQueryParam(
        string $name,
        mixed $default = null
    ): mixed {
        return $this->queryParams[$name] ?? $default;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getHeader(
        string $name
    ): ?string {
        foreach ($this->headers as $header => $value) {
            if (strcasecmp($header, $name) === 0) {
                return $value;
            }
        }

        return null;
    }
}