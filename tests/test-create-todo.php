<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Bootstrap\ApplicationFactory;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$factory = new ApplicationFactory(
    $entityManager
);

// 1. Autenticamos al usuario
$loginUser = $factory->createLoginUser();

$user = $loginUser->execute(
    'pedro',
    'ABC123'
);

echo 'Login successful!' . PHP_EOL;
echo 'User ID: ' . $user->getId() . PHP_EOL;

// 2. Creamos el TODO
$createTodo = $factory->createCreateTodo();

$todo = $createTodo->execute(
    'Aprender arquitectura hexagonal',
    'Construir el TODO List paso a paso'
);

echo 'Todo created!' . PHP_EOL;
echo 'Todo ID: ' . $todo->getId() . PHP_EOL;
echo 'Title: ' . $todo->getTitle() . PHP_EOL;
echo 'Created by: '
    . $todo->getCreatedBy()->getUsername()
    . PHP_EOL;