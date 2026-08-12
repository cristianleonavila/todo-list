<?php

namespace App\Infrastructure\Bootstrap;

use App\Application\User\LoginUser;
use App\Application\User\RegisterUser;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Infrastructure\Security\PhpPasswordHasher;
use App\Infrastructure\Security\PhpSessionAuthentication;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationFactory
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function createRegisterUser()
    {
        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $passwordHasher = new PhpPasswordHasher();

        return new RegisterUser(
            $userRepository,
            $passwordHasher
        );
    }

    public function createLoginUser()
    {
        $userRepository = new DoctrineUserRepository(
            $this->entityManager
        );

        $passwordHasher = new PhpPasswordHasher();

        $authenticationSession = new PhpSessionAuthentication();

        return new LoginUser(
            $userRepository,
            $passwordHasher,
            $authenticationSession
        );
    }
}