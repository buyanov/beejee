<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\Response;
use TaskManager\Request\LoginFormRequest;

class LoginController extends Controller
{
    public function __invoke(LoginFormRequest $request): Response
    {
        $formData = $request->validate();

        if (isset($formData['errors'])) {
            return twig('login.twig', [
                'form' => $formData
            ]);
        }

        $loginData = $formData['data'];
        auth()->attempt($loginData['username'], $loginData['password']);

        if (!auth()->user()) {
            error('Login failed!');
            return $this->redirect('/login');
        }

        return $this->redirect();
    }
}
