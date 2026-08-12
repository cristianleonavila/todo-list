<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Todo\ListUserTodos;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;

class TodoController
{
    public function __construct(
        private ListUserTodos $listUserTodos
    ) {
    }

    public function list(Request $request): Response
    {
        $todos = $this->listUserTodos->execute();

        $result = [];

        foreach ($todos as $todo) {
            $result[] = [
                'id' => $todo->getId(),
                'title' => $todo->getTitle(),
                'description' => $todo->getDescription(),
                'completed' => $todo->isCompleted(),
            ];
        }

        return new Response($result);
    }
}