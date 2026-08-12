<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Domain\User\User;
use App\Domain\Todo\Todo;

$entityManager = require __DIR__ . '/../config/doctrine.php';

foreach ([User::class, Todo::class] as $entityClass) {
    $metadata = $entityManager
        ->getClassMetadata($entityClass);

    echo 'Entity: ' . $metadata->getName() . PHP_EOL;
    echo 'Table: ' . $metadata->getTableName() . PHP_EOL;

    echo 'Fields:' . PHP_EOL;

    foreach ($metadata->getFieldNames() as $field) {
        echo '- ' . $field . PHP_EOL;
    }
    echo 'Associations:' . PHP_EOL;

    foreach ($metadata->getAssociationNames() as $association) {
        echo '- ' . $association . PHP_EOL;
    }    

    echo PHP_EOL;
}