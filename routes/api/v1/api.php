<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(static function (): void {
    Route::get('ping', static fn() => 'v1 pong');
});
