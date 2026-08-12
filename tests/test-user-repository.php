<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Domain\User\User;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$repository = new DoctrineUserRepository(
    $entityManager
);

$user = new User(
    'cristian',
    'some-password'
);

$repository->save($user);

echo 'User saved!' . PHP_EOL;
echo 'ID: ' . $user->getId() . PHP_EOL;

$foundUser = $repository->findById(
    $user->getId()
);

echo 'Found user: ' . $foundUser->getUsername() . PHP_EOL;