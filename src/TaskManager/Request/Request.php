<?php

declare(strict_types=1);

namespace TaskManager\Request;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Request
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    public function __construct(ContainerInterface $container)
    {
        $app = $container->get('app');
        $this->request = $app->getRequest();
    }

    public function getSession(): SessionInterface
    {
        return $this->request->getSession();
    }

    public function uri(): string
    {
        return $this->request->getRequestUri();
    }

    public function getContent()
    {
        return $this->request->getContent();
    }

    public function get(string $key, $default = null)
    {
        return $this->request->get($key, $default);
    }
}
