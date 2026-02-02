<?php

use App\Http\Controllers\Main\Lojas\LojaController;
use App\Http\Controllers\Main\MainDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [MainDashboardController::class, 'index'])->name('dashboard.index');
        Route::prefix('/lojas')->name('dashboard.lojas.')->group(function () {
            Route::get('/', [LojaController::class, 'index'])->name('index');
            Route::get('/show/{loja}', [LojaController::class, 'show'])->name('show');
            Route::get('/create', [LojaController::class, 'create'])->name('create');
            Route::post('/store', [LojaController::class, 'store'])->name('store');
            Route::get('/edit/{loja}', [LojaController::class, 'edit'])->name('edit');
            Route::put('/update/{loja}', [LojaController::class, 'update'])->name('update');
            Route::get('/apagados', [LojaController::class, 'deleted'])->name('deleted');
            Route::delete('/destroy/{loja}', [LojaController::class, 'destroy'])->name('destroy');
        });
    });
});
