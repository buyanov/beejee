<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use TaskManager\Application;
use Twig\Loader\FilesystemLoader;

return [

    Application::class => static function(ContainerInterface $container) {
        $request = Request::createFromGlobals();
        $response = new Response();
        return new Application($request, $response, $container);
    },

    'app' => DI\get(Application::class),

    Environment::class => static function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/TaskManager/Views');
        return new Environment($loader);
    },
];
