<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller
{
    public function redirect(string $to = '/', int $status = 302, array $headers = []): RedirectResponse
    {
        return new RedirectResponse($to, $status, $headers);
    }
}
