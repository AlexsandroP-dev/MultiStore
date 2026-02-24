<?php

use App\Http\Controllers\Lojista\LojaDashboardController;
use App\Http\Controllers\Lojista\Lojas\CargoController;
use App\Http\Controllers\Lojista\Lojas\ColaboradorController;
use App\Http\Controllers\Lojista\Lojas\EstoqueController;
use App\Http\Controllers\Lojista\Lojas\FinanceiroController;
use App\Http\Controllers\Lojista\Lojas\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'config.loja']], function () {
    Route::prefix('loja/{loja}/dashboard')->name('loja.dashboard.')->group(function () {
        Route::get('/', [LojaDashboardController::class, 'index'])->name('index');
        //Produtos
        Route::prefix('/produtos')->name('produtos.')->group(function () {
            Route::get('/', [ProdutoController::class, 'index'])->name('index');
            Route::get('/create', [ProdutoController::class, 'create'])->name('create');
            Route::post('/store', [ProdutoController::class, 'store'])->name('store');
            Route::post('/store/categoria', [ProdutoController::class, 'storeCategoria'])->name('store.categoria');
            Route::get('/setVisualizacao/{modo}', [ProdutoController::class, 'setVisualizacao'])->name('set.visualizacao');
        });

        //Produtos cujo requerem parametro categoria
        Route::prefix('/categoria/{categoria}/produto/{produto}')->name('produtos.')->group(function () {
            Route::get('/show', [ProdutoController::class, 'show'])->name('show');
            Route::get('/edit', [ProdutoController::class, 'edit'])->name('edit');
            Route::put('/update', [ProdutoController::class, 'update'])->name('update');

            //Estoque do produto
            Route::prefix('/show')->name('show.estoque.')->group(function () {
                Route::post('/estoque/store', [EstoqueController::class, 'store'])->name('store');
                Route::put('/estoque/update/{estoque}', [EstoqueController::class, 'update'])->name('update');
            });
        });

        //Colaboradores
        Route::prefix('/colaboradores')->name('colaboradores.')->group(function () {
            Route::get('/', [ColaboradorController::class, 'index'])->name('index');
            Route::get('/create', [ColaboradorController::class, 'create'])->name('create');
            Route::post('/store', [ColaboradorController::class, 'store'])->name('store');
            Route::post('/vincular', [ColaboradorController::class, 'vincularColaborador'])->name('vincular');
            Route::put('/{colaborador}/inativar/', [ColaboradorController::class, 'inativarColaborador'])->name('inativar');
            Route::put('/{colaborador}/reativar/', [ColaboradorController::class, 'reativarColaborador'])->name('reativar');
            Route::post('/{colaborador}/cargo/atribuir', [ColaboradorController::class, 'setCargoColaborador'])->name('atribuirCargo');
            Route::get('/setVisualizacao/{modo}', [ColaboradorController::class, 'setVisualizacao'])->name('set.visualizacao');

            //Cargos
            Route::prefix('/cargo')->name('cargo.')->group(function () {
                Route::post('/store', [CargoController::class, 'store'])->name('store');
                Route::put('/update/{cargo}', [CargoController::class, 'update'])->name('update');
                Route::delete('/reativar/{cargo}', [CargoController::class, 'destroy'])->name('destroy');
            });
        });

        //Financeiro
        Route::prefix('/financeiro')->name('financeiro.')->group(function () {
            Route::get('/', [FinanceiroController::class, 'index'])->name('index');
            Route::post('/store', [FinanceiroController::class, 'store'])->name('store');
            Route::put('/update/{financeiro}', [FinanceiroController::class, 'update'])->name('update');
            Route::prefix('/categoria')->name('categoria.')->group(function () {
                Route::post('/categoria/store', [FinanceiroController::class, 'storeCategoria'])->name('store');
                Route::put('/categoria/update/{categoria}', [FinanceiroController::class, 'updateCategoria'])->name('update');
            });
        });
    });
});
