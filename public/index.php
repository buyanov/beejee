<?php

require_once '../bootstrap/container.php';

require_once '../vendor/larapack/dd/src/helper.php';

$app = $container->get('app');

$app->dispatch();

$app->run();