<?php

use App\Http\Controllers\Main\Lojas\CargoController;
use App\Http\Controllers\Main\Lojas\LojaController;
use App\Http\Controllers\Main\MainDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [MainDashboardController::class, 'index'])->name('dashboard.index');
        Route::prefix('/lojas')->name('dashboard.lojas.')->group(function () {
            Route::get('/', [LojaController::class, 'index'])->name('index');
            Route::get('/{loja}/show', [LojaController::class, 'show'])->name('show');
            Route::get('/create', [LojaController::class, 'create'])->name('create');
            Route::post('/store', [LojaController::class, 'store'])->name('store');
            Route::get('/{loja}/edit', [LojaController::class, 'edit'])->name('edit');
            Route::put('/{loja}/update', [LojaController::class, 'update'])->name('update');
            Route::put('/{loja}/renovar', [LojaController::class, 'renew'])->name('update.renew');
            Route::get('/apagados', [LojaController::class, 'deleted'])->name('deleted');
            Route::delete('/{loja}/destroy', [LojaController::class, 'destroy'])->name('destroy');

            //Colaborador
            Route::prefix('/{loja}/show/colaborador')->name('show.colaborador.')->group(function () {
                Route::post('/store', [LojaController::class, 'storeColaborador'])->name('store');
                Route::post('/vincular', [LojaController::class, 'vincularColaborador'])->name('vincular');
                Route::put('/inativar/{user}', [LojaController::class, 'inativarColaborador'])->name('inativar');
                Route::put('/reativar/{user}', [LojaController::class, 'reativarColaborador'])->name('reativar');
                Route::post('/{lojista}/cargo/atribuir', [LojaController::class, 'setCargoColaborador'])->name('atribuirCargo');
            });

            //Cargo
            Route::prefix('/{loja}/show/cargo')->name('show.cargo.')->group(function () {
                Route::post('/store', [CargoController::class, 'store'])->name('store');
                Route::put('/update/{cargo}', [CargoController::class, 'update'])->name('update');
                Route::delete('/reativar/{cargo}', [CargoController::class, 'destroy'])->name('destroy');
            });
        });
    });
});
