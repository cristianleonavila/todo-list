<?php

namespace App\Application\Todo;

use App\Application\Security\AuthenticationSession;
use App\Domain\Todo\Todo;
use App\Domain\Todo\TodoRepository;
use App\Domain\User\UserRepository;
use InvalidArgumentException;

class CreateTodo
{
    private $todoRepository;
    private $userRepository;
    private $authenticationSession;

    public function __construct(
        TodoRepository $todoRepository,
        UserRepository $userRepository,
        AuthenticationSession $authenticationSession
    ) {
        $this->todoRepository = $todoRepository;
        $this->userRepository = $userRepository;
        $this->authenticationSession = $authenticationSession;
    }

    public function execute(
        CreateTodoInput $input
    ) {
        if ( !$input->title ) {
            throw new InvalidArgumentException("Title is empty");
        }
        if ( !$input->description ) {
            throw new InvalidArgumentException("Description is empty");
        }        
        $userId = $this->authenticationSession
            ->getCurrentUserId();

        if ($userId === null) {
            throw new \RuntimeException(
                'User is not authenticated'
            );
        }

        $user = $this->userRepository
            ->findById($userId);

        if ($user === null) {
            throw new \RuntimeException(
                'Authenticated user not found'
            );
        }

        $todo = new Todo(
            $user,
            $input->title,
            $input->description
        );

        $this->todoRepository->save($todo);

        return $todo;
    }
}