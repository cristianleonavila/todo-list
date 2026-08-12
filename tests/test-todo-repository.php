<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Domain\Todo\Todo;
use App\Infrastructure\Persistence\Doctrine\DoctrineTodoRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$userRepository = new DoctrineUserRepository(
    $entityManager
);

$todoRepository = new DoctrineTodoRepository(
    $entityManager
);

$user = $userRepository->findByUsername('juan');

if ($user === null) {
    throw new RuntimeException('User not found');
}

$todo = new Todo(
    $user,
    'Aprender arquitectura hexagonal',
    'Continuar construyendo el TODO List'
);

$todoRepository->save($todo);

echo 'Todo saved!' . PHP_EOL;
echo 'ID: ' . $todo->getId() . PHP_EOL;
echo 'Title: ' . $todo->getTitle() . PHP_EOL;
echo 'User: ' . $todo->getCreatedBy()->getUsername() . PHP_EOL;