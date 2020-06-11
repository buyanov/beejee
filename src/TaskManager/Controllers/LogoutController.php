<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function __invoke(): Response
    {
        auth()->logout();

        return $this->redirect();
    }
}
