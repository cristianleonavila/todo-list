<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Bootstrap\ApplicationFactory;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$factory = new ApplicationFactory(
    $entityManager
);

$loginUser = $factory->createLoginUser();

$user = $loginUser->execute(
    'juan',
    'my-secret-password'
);

echo 'Login successful!' . PHP_EOL;
echo 'User ID: ' . $user->getId() . PHP_EOL;
echo 'Username: ' . $user->getUsername() . PHP_EOL;