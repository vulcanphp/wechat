<?php

namespace App\Http\Middlewares;

use VulcanPhp\PhpRouter\Http\Request;
use VulcanPhp\PhpRouter\Http\Response;
use VulcanPhp\PhpRouter\Security\Interfaces\IMiddleware;

class LoginGuard implements IMiddleware
{
    public function handle(Request $request, Response $response): void
    {
        if (app()
            ->getComponent('auth')
            ->isLogged()
        ) {
            $response->redirect('/');
        }
    }
}
