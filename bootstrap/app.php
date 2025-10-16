<?php

use App\Http\Middleware\DetectClientSubdomain;
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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cors' => \App\Http\Middleware\CorsMiddleware::class,
            'jwt' => \App\Http\Middleware\JWTMiddleware::class,
             'checkSubdomain' => DetectClientSubdomain::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        // Force JSON for API routes
        $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

        // Handle 404 errors (endpoint not found)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->json([
                'message' => 'Endpoint not found',
                'status' => 404
            ], 404);
        });

        // Handle wrong HTTP method (GET instead of POST, etc.)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e) {
            return response()->json([
                'message' => 'HTTP method not allowed for this endpoint',
                'status' => 405
            ], 405);
        });

        // Handle all other errors
        $exceptions->render(function (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage() ?: 'Server error occurred',
                'status' => 500
            ], 500);
        });
    })->create();
