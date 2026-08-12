<?php

namespace App\Application\Security;

use App\Application\Security\AuthenticationSession;
use App\Application\Security\PasswordHasher;
use App\Domain\User\UserRepository;

class LoginUser
{
    private $userRepository;
    private $passwordHasher;
    private $authenticationSession;

    public function __construct(
        UserRepository $userRepository,
        PasswordHasher $passwordHasher,
        AuthenticationSession $authenticationSession
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->authenticationSession = $authenticationSession;
    }

    public function execute(
        $username,
        $password
    ) {
        $user = $this->userRepository
            ->findByUsername($username);

        if ($user === null) {
            throw new \RuntimeException(
                'Invalid credentials'
            );
        }

        if (!$this->passwordHasher->verify(
            $password,
            $user->getPassword()
        )) {
            throw new \RuntimeException(
                'Invalid credentials'
            );
        }

        $this->authenticationSession->login($user);

        return $user;
    }
}