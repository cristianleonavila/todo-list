<?php

namespace App\Application\Todo;

use App\Application\Security\AuthenticationSession;
use App\Application\Shared\Exception\ForbiddenException;
use App\Domain\Todo\Todo;
use App\Domain\Todo\TodoRepository;
use App\Domain\User\UserRepository;

class DeleteTodo {

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

    public function execute($todoId) {
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
            throw new ForbiddenException(
                'You cannot delete this todo'
            );
        }

        $this->todoRepository->delete($todo);
    }    
}