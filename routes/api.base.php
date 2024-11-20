<?php

use App\Presentation\Http\Controllers\API\AuthController;
use App\Presentation\Http\Controllers\API\GetOneTimeTokenController;
use App\Presentation\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(static function (): void {
    Route::get('ping', static fn() => 'pong');
    
    Route::post('me', [AuthController::class, 'login'])->name('auth.login');
    Route::post('me/otp', [AuthController::class, 'loginUsingOneTimeToken']);

    Route::middleware('auth:api')->group(static function (): void {
        Route::get('one-time-token', GetOneTimeTokenController::class);
        Route::delete('me', [AuthController::class, 'logout'])->name('auth.logout');

    });
    Route::apiResource('users', UserController::class);
});
