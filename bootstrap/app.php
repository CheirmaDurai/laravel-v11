<?php

use App\Http\Middleware\PreProcessor;
use App\Http\Middleware\PostProcessor;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/');
        $middleware->alias([
            'process-request' => PreProcessor::class,
            'process-response' => PostProcessor::class,
        ]);

        $middleware->group('processor', [
            PreProcessor::class,
            PostProcessor::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'authenticate',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
