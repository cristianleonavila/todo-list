<?php

require __DIR__ . '/../vendor/autoload.php';

$entityManager = require __DIR__ . '/../config/doctrine.php';

$metadata = $entityManager
    ->getMetadataFactory()
    ->getAllMetadata();

$schemaTool = new Doctrine\ORM\Tools\SchemaTool(
    $entityManager
);

$sql = $schemaTool->getCreateSchemaSql($metadata);

foreach ($sql as $statement) {
    echo $statement . PHP_EOL;
}