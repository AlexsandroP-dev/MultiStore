<?php

use App\Http\Controllers\Lojista\LojaDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'config.loja']], function () {
    Route::prefix('loja/{loja}/dashboard')->name('loja.dashboard.')->group(function () {
        Route::get('/', [LojaDashboardController::class, 'index'])->name('index');
    });
});