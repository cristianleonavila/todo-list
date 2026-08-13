<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Bootstrap\ApplicationFactory;
use App\Infrastructure\Http\ExceptionHandler;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;
use App\Infrastructure\Http\Router;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$factory = new ApplicationFactory(
    $entityManager
);

$router = new Router();

$authController = $factory->createAuthController();

$router->post(
    '/api/login',
    [$authController, 'login']
);

$router->post(
    '/api/logout',
    [$authController, 'logout']
);

$todoController = $factory->createTodoController();

$router->get(
    '/api/todos',
    [$todoController, 'list']
);

$router->get(
    '/api/test/{id}',
    function (
        Request $request,
        array $parameters
    ) {
        return new Response([
            'id' => (int) $parameters['id']
        ]);
    }
);

$router->post(
    '/api/todos/{id}/complete',
    [$todoController, 'complete']
);

$router->post(
    '/api/todos/{id}/reopen',
    [$todoController, 'reopen']
);

$router->patch(
    '/api/todos/{id}',
    [$todoController, 'update']
);

$router->delete(
    '/api/todos/{id}',
    [$todoController, 'delete']
);

$router->post(
    '/api/todos',
    [$todoController, 'create']
);

$userController = $factory->createUserController();

$router->post(
    '/api/users',
    [$userController, 'create']
);

try {
    $request = Request::fromGlobals();

    $result = $router->dispatch($request);

    if ($result instanceof Response) {
        $result->send();
    }
} catch (\Throwable $exception) {
    $handler = new ExceptionHandler();

    $response = $handler->handle($exception);

    $response->send();
}