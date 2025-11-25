<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::post("sign-up", [UserController::class, 'signUp']);
        Route::post("sign-in", [UserController::class, 'signIn']);
        Route::get("refresh", [UserController::class, 'refresh']);

        Route::middleware([JwtMiddleware::class])->group(function () {
            Route::get("me", [UserController::class, 'me']);
        });
    });
});
