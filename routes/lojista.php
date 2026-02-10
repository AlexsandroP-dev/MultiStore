<?php

use App\Http\Controllers\Lojista\LojaDashboardController;
use App\Http\Controllers\Lojista\Lojas\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'config.loja']], function () {
    Route::prefix('loja/{loja}/dashboard')->name('loja.dashboard.')->group(function () {
        Route::get('/', [LojaDashboardController::class, 'index'])->name('index');
        Route::prefix('/produtos')->name('produtos.')->group(function () {
            Route::get('/', [ProdutoController::class, 'index'])->name('index');
            Route::get('/{produto}/show', [ProdutoController::class, 'show'])->name('show');
            Route::get('/create', [ProdutoController::class, 'create'])->name('create');
            Route::post('/store', [ProdutoController::class, 'store'])->name('store');
            Route::post('/store/categoria', [ProdutoController::class, 'storeCategoria'])->name('store.categoria');
            Route::get('/{produto}/edit', [ProdutoController::class, 'edit'])->name('edit');
            Route::put('/{produto}/update', [ProdutoController::class, 'update'])->name('update');
        });
    });
});
