<?php

namespace App\Application\Todo;

use App\Application\Security\AuthenticationSession;
use App\Domain\Todo\TodoRepository;
use App\Domain\User\UserRepository;

class ListUserTodos
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

    public function execute()
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

        return $this->todoRepository
            ->findByUser($user);
    }
}