<?php

namespace TaskManager;

use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    private $dispatcher;
    private $request;
    private $response;

    public function __construct(Request $request, Response $response, ContainerInterface $container)
    {

        $this->dispatcher = \FastRoute\simpleDispatcher(static function(RouteCollector $r) {
            include '../routes.php';
        });

        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    public function dispatch()
    {
        $routeInfo = $this->dispatcher->dispatch($this->request->getRealMethod(), $this->request->getRequestUri());

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $this->response = $this->container->call($handler, $vars);
                break;
        }
    }

    public function run()
    {

        return $this->response->send();
    }
}