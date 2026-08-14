<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Todo\CompleteTodo;
use App\Application\Todo\CreateTodo;
use App\Application\Todo\CreateTodoInput;
use App\Application\Todo\DeleteTodo;
use App\Application\Todo\ListUserTodos;
use App\Application\Todo\ReopenTodo;
use App\Application\Todo\UpdateTodo;
use App\Application\Todo\UpdateTodoInput;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;

class TodoController
{
    public function __construct(
        private ListUserTodos $listUserTodos,
        private CompleteTodo $completeTodo,
        private ReopenTodo $reopenTodo,
        private UpdateTodo $updateTodo,
        private DeleteTodo $deleteTodo,
        private CreateTodo $createTodo
    ) {}

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

    public function complete(
        Request $request,
        array $parameters
    ): Response {
        $todoId = (int) $parameters['id'];

        $this->completeTodo->execute($todoId);

        return new Response([
            'message' => 'Todo completed'
        ]);
    }

    public function reopen(
        Request $request,
        array $parameters
    ): Response {
        $todoId = (int) $parameters['id'];

        $this->reopenTodo->execute($todoId);

        return new Response([
            'message' => 'Todo reopened'
        ]);
    }    

    public function update(
        Request $request,
        array $parameters
    ): Response {
        $todoId = (int) $parameters['id'];
        $body = $request->getBody();
        if (
            !isset($body['title']) &&
            !is_string($body['title']) &&
            !isset($body['description']) &&
            !is_string($body['description'])
        ) {
            return new Response([
                'message' => 'Bad Request'
            ], 400);            
        }        
        $this->updateTodo->execute(
            $todoId, 
            new UpdateTodoInput(
                $body['title'] ?? null, 
                $body['description'] ?? null
            )
        );

        return new Response([
            'message' => 'Todo updated!'
        ]);
    }   
    
    public function delete(
        Request $request,
        array $parameters
    ): Response {
        $todoId = (int) $parameters['id'];
        $body = $request->getBody();
        $this->deleteTodo->execute($todoId);

        return new Response([
            'message' => 'Todo deleted!'
        ]);
    }
    
    public function create(
        Request $request
    ): Response {
        $body = $request->getBody();
        if (
            !isset($body['title']) ||
            !is_string($body['title']) ||
            !isset($body['description']) ||
            !is_string($body['description'])
        ) {
            return new Response([
                'message' => 'Bad Request'
            ], 400);            
        }        
        $todo = $this->createTodo->execute(
            new CreateTodoInput($body['title'], $body['description'])
        );
        return new Response([
            'message' => 'Todo created!',
            'id' => $todo->getId()
        ]);
    }
}
