<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/bootstrap/container.php';

$entityManager = $container->get('db.entity_manager');

return ConsoleRunner::createHelperSet($entityManager);