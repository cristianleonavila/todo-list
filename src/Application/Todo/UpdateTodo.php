<?php

namespace App\Application\Todo;

use App\Application\Security\AuthenticationSession;
use App\Domain\Todo\TodoRepository;
use App\Domain\User\UserRepository;

class UpdateTodo
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

    public function execute($todoId, string $title, string $description)
    {
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

        $todo = $this->todoRepository
            ->findById($todoId);

        if ($todo === null) {
            throw new \RuntimeException(
                'Todo not found'
            );
        }

        if ($todo->getCreatedBy()->getId() !== $user->getId()) {
            throw new \RuntimeException(
                'You cannot complete this todo'
            );
        }

        $todo->changeTitle($title);
        $todo->changeDescription($description);

        $this->todoRepository->save($todo);

        return $todo;
    }
}