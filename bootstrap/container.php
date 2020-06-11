<?php

use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/di.php');

$container = $builder->build();