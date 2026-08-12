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
$deleteTodo = $factory->createDeleteTodo();

$deleteTodo->execute(1);

echo 'Todo deleted!' . PHP_EOL;