<?php declare(strict_types = 1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController
{

    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(): Response
    {
        $content = $this->twig->render('home.twig');

        return new Response($content);
    }
}
