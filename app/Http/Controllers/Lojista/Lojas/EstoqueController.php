<?php

namespace App\Http\Controllers\Lojista\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lojas\EstoqueRequest;
use App\Models\Lojas\Estoque;
use App\Models\Lojas\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    protected $estoques;
    protected $bag = [
        'view' => 'lojas.produtos',
        'route' => 'loja.dashboard.produtos.show.estoque',
        'routeProduto' => 'loja.dashboard.produtos.show',
        'title' => 'Estoques',
        'subtitle' => 'todos os estoques do produto',
        'section' => [
            'index' => 'Estoques Cadastrados',
            'create' => 'Cadastrar Estoque',
            'edit' => 'Editar Estoque',
            'show' => 'Visualizando Estoque'
        ]
    ];

    public function __construct(Estoque $estoques)
    {
        View::share('bag', $this->bag);
        $this->estoques = $estoques;
    }

    public function store(EstoqueRequest $request, $loja, $categoria, Produto $produto)
    {
        DB::beginTransaction();
        try {
            $this->estoques->create($request->validated() + [
                'produto_id' => $produto->id,
                'disponivel' => true
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Estoque cadastrado com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o estoque:');
        }
    }

    public function update(EstoqueRequest $request, $loja, $categoria, Produto $produto, Estoque $estoque)
    {
        DB::beginTransaction();
        try {
            $estoque->update($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Estoque atualizado com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o estoque:');
        }
    }
}
