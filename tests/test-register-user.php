<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application\User\RegisterUser;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Infrastructure\Security\PhpPasswordHasher;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$userRepository = new DoctrineUserRepository(
    $entityManager
);

$passwordHasher = new PhpPasswordHasher();

$registerUser = new RegisterUser(
    $userRepository,
    $passwordHasher
);

$user = $registerUser->execute(
    'pedro',
    'ABC123'
);

echo 'User registered!' . PHP_EOL;
echo 'ID: ' . $user->getId() . PHP_EOL;
echo 'Username: ' . $user->getUsername() . PHP_EOL;
echo 'Password: ' . $user->getPassword() . PHP_EOL;