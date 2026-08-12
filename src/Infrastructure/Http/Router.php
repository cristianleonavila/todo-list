<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

class Router
{
    private array $routes = [];

    public function get(
        string $path,
        callable $handler
    ): void {
        $this->addRoute(
            'GET',
            $path,
            $handler
        );
    }

    public function post(
        string $path,
        callable $handler
    ): void {
        $this->addRoute(
            'POST',
            $path,
            $handler
        );
    }

    public function put(
        string $path,
        callable $handler
    ): void {
        $this->addRoute(
            'PUT',
            $path,
            $handler
        );
    }

    public function patch(
        string $path,
        callable $handler
    ): void {
        $this->addRoute(
            'PATCH',
            $path,
            $handler
        );
    }

    public function delete(
        string $path,
        callable $handler
    ): void {
        $this->addRoute(
            'DELETE',
            $path,
            $handler
        );
    }

    private function addRoute(
        string $method,
        string $path,
        callable $handler
    ): void {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(
        Request $request
    ): mixed {
        $handler = $this->routes[
            $request->getMethod()
        ][$request->getPath()] ?? null;

        if ($handler === null) {
            throw new \RuntimeException(
                'Route not found'
            );
        }

        return $handler($request);
    }
}