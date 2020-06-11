<?php

namespace TaskManager;

use DI\Container;
use Doctrine\ORM\EntityManager;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use TaskManager\Auth\Guard;
use function FastRoute\simpleDispatcher;

class Application
{
    protected $dispatcher;
    protected $request;
    protected $response;
    protected $session;

    /**
     * @var EntityManager
     */
    protected $db;

    protected $guard;

    /**
     * @var Container
     */
    protected static $container;
    protected static $instance;

    public function __construct()
    {
        $this->dispatcher = simpleDispatcher(static function (RouteCollector $r) {
            include '../routes.php';
        });

        $this->request = self::$container->get('request');
        $this->response = self::$container->get('response');
        $this->db = self::$container->get('db.entity_manager');
        $this->session = self::$container->get('session');
        $this->session->start();
        $this->request->setSession($this->session);

        $this->guard = new Guard($this->session, $this->request, $this->db);
    }

    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    public static function getContainer(): Container
    {
        return self::$container;
    }

    public static function getInstance(): Application
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function dispatch(): void
    {
        $routeInfo = $this->dispatcher->dispatch($this->request->getRealMethod(), $this->request->getRequestUri());
        [$dispatcherResult, $handler, $vars] = $routeInfo;
        
        switch ($dispatcherResult) {
            case Dispatcher::NOT_FOUND:
                $this->response = new Response('404 - Not Found', 404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->response = new Response('405 - Method Not Allowed', 405);
                break;
            case Dispatcher::FOUND:
                $this->response = self::$container->call($handler, $vars);
                break;
        }
    }


    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getGuard(): Guard
    {
        return $this->guard;
    }

    public function getDB(): EntityManager
    {
        return $this->db;
    }

    public function run(): Response
    {
        return $this->response->send();
    }

    public function debug()
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        $whoops->register();
    }
}
