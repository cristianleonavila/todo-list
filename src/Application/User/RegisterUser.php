<?php

namespace App\Application\User;

use App\Application\Security\PasswordHasher;
use App\Application\User\Exception\UserAlreadyExistsException;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use InvalidArgumentException;

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
        RegisterUserInput $input
    ) {
        if ( !$input->username ) {
            throw new InvalidArgumentException("The username is empty");
        }
        if ( !$input->password ) {
            throw new InvalidArgumentException("The password is empty");
        }        
        $existingUser = $this->userRepository
            ->findByUsername($input->username);

        if ($existingUser !== null) {
            throw new UserAlreadyExistsException(
                'User already exists'
            );
        }

        $hashedPassword = $this->passwordHasher
            ->hash($input->password);

        $user = new User(
            $input->username,
            $hashedPassword
        );

        $this->userRepository->save($user);

        return $user;
    }
}