<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use TaskManager\Application;
use TaskManager\Auth\Guard;
use Twig\TwigFunction;

function app(): Application
{
    return Application::getInstance();
}

function request(): Request
{
    return app()->getRequest();
}

function session(): Session
{
    return app()->getSession();
}

function db(): EntityManager
{
    return app()->getDB();
}

function auth(): Guard
{
    return app()->getGuard();
}

function success(string $message)
{
    session()->getFlashBag()->add('success', $message);
}

function error(string $message)
{
    session()->getFlashBag()->add('danger', $message);
}

function notice(string $message)
{
    session()->getFlashBag()->add('info', $message);
}

function warning(string $message)
{
    session()->getFlashBag()->add('warning', $message);
}

function twig(string $template, array $data = [])
{
    /** @var \Twig\Environment $twig */
    $twig = app()::getContainer()->get('twig');

    $twig->addFunction(new TwigFunction('auth', static function () {
        return app()->getGuard()->user() ? true : false;
    }));

    $twig->addFunction(new TwigFunction('alerts', static function () {
        $messages = session()->getFlashBag()->all();
        session()->getFlashBag()->clear();
        return $messages;
    }));

    return new Response($twig->render($template, $data));
}
