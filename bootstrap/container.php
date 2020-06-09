<?php

use DI\ContainerBuilder;

require_once '../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions('../config/di.php');

$container = $builder->build();
