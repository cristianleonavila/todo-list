<?php

$entityManager = require __DIR__ . '/config/doctrine.php';

$connection = $entityManager->getConnection();

echo $connection->getDatabase() . PHP_EOL;