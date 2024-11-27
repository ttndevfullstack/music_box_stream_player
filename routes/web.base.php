<?php

use App\Presentation\Http\Controllers\Web\IndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(static function (): void {
    Route::get('/', IndexController::class);
});
