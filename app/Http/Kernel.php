<?php

namespace App\Http;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        // Laravel defaults...
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Your custom middleware
        'role' => \App\Http\Middleware\CheckRole::class,
        'log.activity' => \App\Http\Middleware\LogActivity::class,
        'active.user' => \App\Http\Middleware\CheckActiveUser::class,
    ];
}
