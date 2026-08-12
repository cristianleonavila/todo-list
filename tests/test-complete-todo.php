<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Bootstrap\ApplicationFactory;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$factory = new ApplicationFactory(
    $entityManager
);

// Login como Juan
$loginUser = $factory->createLoginUser();

$user = $loginUser->execute(
    'juan',
    'my-secret-password'
);

echo 'Logged in as: '
    . $user->getUsername()
    . PHP_EOL;

// Completar TODO
$completeTodo = $factory->createCompleteTodo();

$todo = $completeTodo->execute(3);

echo 'Todo completed!' . PHP_EOL;
echo 'ID: ' . $todo->getId() . PHP_EOL;
echo 'Title: ' . $todo->getTitle() . PHP_EOL;
echo 'Completed: '
    . ($todo->isCompleted() ? 'yes' : 'no')
    . PHP_EOL;