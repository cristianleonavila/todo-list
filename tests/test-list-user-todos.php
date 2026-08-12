<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Bootstrap\ApplicationFactory;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$factory = new ApplicationFactory(
    $entityManager
);

// Login como Juan
$loginUser = $factory->createLoginUser();

$loginUser->execute(
    'pedro',
    'ABC123'
);

// Obtener TODOs del usuario autenticado
$listUserTodos = $factory->createListUserTodos();

$todos = $listUserTodos->execute();

echo 'TODOs de Pedro:' . PHP_EOL;

foreach ($todos as $todo) {
    echo '- ' . $todo->getTitle() . PHP_EOL;
}