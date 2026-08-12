<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;

$entityManager = require __DIR__ . '/doctrine.php';

$config = new PhpFile(
    __DIR__ . '/migrations.php'
);

return DependencyFactory::fromEntityManager(
    $config,
    new ExistingEntityManager($entityManager)
);