<?php

namespace App\Http\Controllers\Lojista\Lojas;

use App\Http\Controllers\Controller;
use App\Models\Lojas\Financeiro\FinanceiroCategoria;
use App\Models\Lojas\Financeiro\FinanceiroMovimentacao;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    protected $financeiros;
    protected $categorias;
    protected $bag = [
        'view' => 'lojas.financeiro',
        'route' => 'loja.dashboard.financeiro',
        'title' => 'Financeiro',
        'subtitle' => 'todas as movimentações financeiras',
        'section' => [
            'index' => 'Movimentações Financeiras',
            'create' => 'Cadastrar Movimentação',
            'edit' => 'Editar Movimentação',
            'show' => 'Visualizando Movimentação'
        ]
    ];

    public function __construct(FinanceiroMovimentacao $financeiros, FinanceiroCategoria $categorias)
    {
        View::share('bag', $this->bag);
        $this->financeiros = $financeiros;
        $this->categorias = $categorias;
    }

    public function index(Request $request)
    {
        $movimentacoes = $this->financeiros->with('categoria')->where('loja_id', session('loja_id'))->paginate(30);
        $links = $movimentacoes->appends($request->except('page'));
        return view($this->bag['view'] . '.index', compact('movimentacoes', 'links'));
    }
}
