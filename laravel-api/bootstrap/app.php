<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \App\Http\Middleware\middlewareDelete;
use \App\Http\Middleware\logRequests;
use \App\Http\Middleware\AuthenticationKeyMiddleware;
use \App\Http\Middleware\MiddlewareUserToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
        ]);
        
        // added to every http requestr
        // $middleware->append(EnsureTokenIsValid::class);
        $middleware->web(append: [
            
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->api(append: [
            // middlewareDelete::class,
            logRequests::class,
            AuthenticationKeyMiddleware::class,
            // middleware_region::class,

            // \App\Http\Middleware\CustomExceptionHandler::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
