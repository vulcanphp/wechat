<?php

namespace App\Http\Kernels;

use App\Core\Pusher;
use VulcanPhp\Core\Auth\Auth;
use VulcanPhp\Core\Foundation\Interfaces\IKernel;

class AppKernel implements IKernel
{
    public function boot(): void
    {
        // initialize basic auth
        app()->setComponent('auth', new Auth());

        // setup pusher
        Pusher::setup(config('pusher'));
    }

    public function shutdown(): void
    {
    }
}
