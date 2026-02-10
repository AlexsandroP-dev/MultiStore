<?php

namespace App\Providers;

use App\Models\Clientes\Pedido;
use App\Observers\PedidoObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Pedido::observe(PedidoObserver::class);
        
        $this->loadMigrationsFrom([
        database_path('migrations/2026_02_02_130000_lojas'),
        database_path('migrations/2026_02_09_130000_clientes'),
        database_path('migrations/2026_02_02_130000_lojas/2026_02_09_130000_financeiro'),
    ]);
    }
}
