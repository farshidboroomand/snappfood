<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api_v1.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Define global middleware here if needed
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Register custom exception handlers here if needed
    })
    ->withEvents(discover: [
      __DIR__ . '/../Modules/V1/*/Listeners',
    ])
    ->create();
