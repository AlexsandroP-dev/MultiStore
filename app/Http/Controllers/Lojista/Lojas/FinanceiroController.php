<?php

namespace App\Http\Controllers\Lojista\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lojas\Financeiro\CategoriaRequest;
use App\Http\Requests\Lojas\Financeiro\FinanceiroRequest;
use App\Models\Clientes\Pedido;
use App\Models\Lojas\Financeiro\FinanceiroCategoria;
use App\Models\Lojas\Financeiro\FinanceiroMovimentacao;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    protected $financeiros;
    protected $categorias;
    protected $pedidos;
    protected $bag = [
        'view' => 'lojas.financeiro',
        'route' => 'loja.dashboard.financeiro',
        'routeCategoria' => 'loja.dashboard.financeiro.categoria',
        'title' => 'Financeiro',
        'subtitle' => 'todas as movimentações financeiras',
        'section' => [
            'index' => 'Movimentações Financeiras',
            'create' => 'Cadastrar Movimentação',
            'edit' => 'Editar Movimentação',
            'show' => 'Visualizando Movimentação'
        ]
    ];

    public function __construct(FinanceiroMovimentacao $financeiros, FinanceiroCategoria $categorias, Pedido $pedidos)
    {
        View::share('bag', $this->bag);
        $this->financeiros = $financeiros;
        $this->categorias = $categorias;
        $this->pedidos = $pedidos;
    }

    public function index(Request $request)
    {
        $query = $this->financeiros->with('categoria')->where('loja_id', session('loja_id'));

        // Coletar todas as movimentações do período para os cálculos
        $movimentacoesParaCalculo = $query->get();

        // 1. Entradas (Somente as que foram pagas/recebidas, ou seja, com data_pagamento preenchida)
        $totalEntradas = $movimentacoesParaCalculo->where('categoria.tipo', 'entrada')->whereNotNull('data_pagamento')->sum('valor');

        // 2. Saídas (Somente as que foram pagas/efetivadas, ou seja, com data_pagamento preenchida)
        $totalSaidas = $movimentacoesParaCalculo->where('categoria.tipo', 'saida')->whereNotNull('data_pagamento')->sum('valor');

        // 3. Saldo Real (Apenas o que já foi efetivamente pago/recebido)
        $saldoAtual = $totalEntradas - $totalSaidas;

        // 4. Pendente (Contas a Pagar/Receber)
        // Entradas sem data_pagamento (crédito futuro) - Saídas sem data_pagamento (débito futuro)
        $entradasPendentes = $movimentacoesParaCalculo->where('categoria.tipo', 'entrada')->whereNull('data_pagamento')->sum('valor');
        $saidasPendentes = $movimentacoesParaCalculo->where('categoria.tipo', 'saida')->whereNull('data_pagamento')->sum('valor');
        $totalPendente = $entradasPendentes - $saidasPendentes;

        $movimentacoes = $query->paginate(10);
        $categorias = $this->categorias->where('loja_id', session('loja_id'))->get();
        $pedidosRecentes = $this->pedidos->where('loja_id', session('loja_id'))->whereIn('status', [Pedido::STATUS_PENDENTE, Pedido::STATUS_PAGO])->latest()->take(10)->get();

        return view($this->bag['view'] . '.index', compact(
            'movimentacoes',
            'categorias',
            'pedidosRecentes',
            'totalEntradas',
            'totalSaidas',
            'saldoAtual',
            'totalPendente'
        ));
    }

    public function store(FinanceiroRequest $request, $loja)
    {
        DB::beginTransaction();
        try {
            // Opcional: Se houver pedido_id, podemos preencher a descrição automaticamente caso esteja vazia
            if ($request->pedido_id && empty($request->descricao)) {
                $validated['descricao'] = "Pagamento referente ao Pedido #" . $request->pedido_id;
            }
            $this->financeiros->create($request->validated() + [
                'loja_id' => session('loja_id'),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Movimentação financeira registrada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar a movimentação financeira:');
        }
    }

    public function update(FinanceiroRequest $request, $loja, FinanceiroMovimentacao $financeiro)
    {
        DB::beginTransaction();
        try {
            $financeiro->update($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Movimentação financeira atualizada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a movimentação financeira:');
        }
    }

    public function destroy($loja, FinanceiroMovimentacao $financeiro)
    {
        DB::beginTransaction();
        try {
            $financeiro->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Movimentação financeira excluída com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao excluir movimentação financeira.');
        }
    }

    public function storeCategoria(CategoriaRequest $request, $loja)
    {
        DB::beginTransaction();
        try {
            $this->categorias->create($request->validated() + [
                'loja_id' => session('loja_id'),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Categoria financeira cadastrada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar a categoria financeira:');
        }
    }

    public function updateCategoria(CategoriaRequest $request, $loja, FinanceiroCategoria $categoria)
    {
        DB::beginTransaction();
        try {
            $categoria->update($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Categoria financeira atualizada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a categoria financeira:');
        }
    }

    public function destroyCategoria($loja, FinanceiroCategoria $categoria)
    {
        DB::beginTransaction();
        try {
            $categoria->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Categoria excluída com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao excluir categoria.');
        }
    }
}
