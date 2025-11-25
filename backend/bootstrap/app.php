<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->append(JwtMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (JWTException $e) {
            return response()->json(["error" => "Token not valid"], 401);
        });

        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        });

        $exceptions->shouldRenderJsonWhen(function ($request) {
            return $request->is('api/*');
        });

        $exceptions->render(function (Throwable $e) {
            return response()->json(["message" => $e->getMessage()]);
        });
    })->create();
