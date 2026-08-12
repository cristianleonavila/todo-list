<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;

require_once __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createConfiguration(
    isDevMode: true
);

$driver = new SimplifiedXmlDriver([
    __DIR__ . '/../src/Infrastructure/Persistence/Doctrine/Mapping/User'
        => 'App\Domain\User',

    __DIR__ . '/../src/Infrastructure/Persistence/Doctrine/Mapping/Todo'
        => 'App\Domain\Todo',
]);

$config->setMetadataDriverImpl($driver);

$config->enableNativeLazyObjects(true);
$connection = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'port'     => 3306,
    'dbname'   => 'todo_list',
    'user'     => 'root',
    'password' => '',
    'charset'  => 'utf8mb4'
]);

$entityManager = new EntityManager(
    $connection,
    $config
);

return $entityManager;