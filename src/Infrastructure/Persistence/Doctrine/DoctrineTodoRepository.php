<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Todo\Todo;
use App\Domain\Todo\TodoRepository;
use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineTodoRepository implements TodoRepository
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function save(Todo $todo)
    {
        $this->entityManager->persist($todo);
        $this->entityManager->flush();
    }

    public function findById($id)
    {
        return $this->entityManager->find(
            Todo::class,
            $id
        );
    }

    public function findByUser(User $user)
    {
        return $this->entityManager
            ->getRepository(Todo::class)
            ->findBy([
                'createdBy' => $user
            ]);
    }

    public function delete(Todo $todo)
    {
        $this->entityManager->remove($todo);
        $this->entityManager->flush();
    }
}