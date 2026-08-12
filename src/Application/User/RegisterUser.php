<?php

namespace App\Application\User;

use App\Application\Security\PasswordHasher;
use App\Domain\User\User;
use App\Domain\User\UserRepository;

class RegisterUser
{
    private $userRepository;
    private $passwordHasher;

    public function __construct(
        UserRepository $userRepository,
        PasswordHasher $passwordHasher
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function execute(
        $username,
        $password
    ) {
        $existingUser = $this->userRepository
            ->findByUsername($username);

        if ($existingUser !== null) {
            throw new \RuntimeException(
                'User already exists'
            );
        }

        $hashedPassword = $this->passwordHasher
            ->hash($password);

        $user = new User(
            $username,
            $hashedPassword
        );

        $this->userRepository->save($user);

        return $user;
    }
}