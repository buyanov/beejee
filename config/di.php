<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use TaskManager\Application;
use Twig\Loader\FilesystemLoader;

return [

    'db.config' => static function() {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        return Setup::createAnnotationMetadataConfiguration(
            [__DIR__."/../src/TaskManager/Models"],
            $isDevMode,
            $proxyDir,
            $cache,
            false
        );
    },

    EntityManager::class => static function(ContainerInterface $c) {
        $conn = [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../db.sqlite',
        ];

        return EntityManager::create($conn, $c->get('db.config'));
    },

    'db.entity_manager' => DI\get(EntityManager::class),

    Application::class => static function(ContainerInterface $container) {
        Request::enableHttpMethodParameterOverride();
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
