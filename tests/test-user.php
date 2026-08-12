<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Domain\User\User;

$user = new User(
    'cristian',
    'some-password'
);

echo $user->getUsername();