<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepository
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById($id)
    {
        return $this->entityManager->find(
            User::class,
            $id
        );
    }

    public function findByUsername($username)
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'username' => $username
            ]);
    }
}