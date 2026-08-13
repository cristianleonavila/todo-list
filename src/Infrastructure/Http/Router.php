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

    private function matchRoute(
        string $method,
        string $path
    ): array {
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace(
                '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
                '(?P<$1>[^/]+)',
                $route
            );

            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                $parameters = [];

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $parameters[$key] = $value;
                    }
                }

                return [
                    'handler' => $handler,
                    'parameters' => $parameters,
                ];
            }
        }

        throw new \RuntimeException('Route not found');
    }

    public function dispatch(Request $request): mixed
    {
        $route = $this->matchRoute(
            $request->getMethod(),
            $request->getPath()
        );

        return ($route['handler'])(
            $request,
            $route['parameters']
        );
    }
}
