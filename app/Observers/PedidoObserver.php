<?php

namespace App\Observers;

use App\Models\Clientes\Pedido;
use App\Models\Financeiro\FinanceiroCategoria;
use App\Models\Lojas\Financeiro\FinanceiroMovimentacao;
use Illuminate\Support\Facades\DB;

class PedidoObserver
{
    public function created(Pedido $pedido): void
    {
        //
    }

    public function updated(Pedido $pedido): void
    {
        // 1. Disparar financeiro ao marcar como PAGO
        if ($pedido->isDirty('status') && $pedido->status === 'pago') {
            $this->registrarEntradaFinanceira($pedido);
        }

        // 2. Subtrair estoque ao marcar como EM PRODUÇÃO
        if ($pedido->isDirty('status') && $pedido->status === 'em_producao') {
            $this->baixarEstoquePedido($pedido);
        }

        // 3. Estorno de valor pago caso status tiver sido 'pago' e depois 'cancelado'
        if ($pedido->isDirty('status') && $pedido->status === 'cancelado') {
            $this->processarCancelamento($pedido);
        }

        // 4. Devolver ao estoque caso status tiver sido 'em_producao', 'concluido' ou 'entregue' e depois 'cancelado e retornado'
        if ($pedido->isDirty('status') && $pedido->status === 'cancelado e retornado') {
            $this->retornarEstoquePedido($pedido);
        }
    }

    public function deleted(Pedido $pedido): void
    {
        //
    }

    public function restored(Pedido $pedido): void
    {
        //
    }

    public function forceDeleted(Pedido $pedido): void
    {
        //
    }

    private function registrarEntradaFinanceira(Pedido $pedido)
    {
        // Busca ou cria a categoria padrão de Vendas
        $categoria = FinanceiroCategoria::firstOrCreate([
            'loja_id' => $pedido->loja_id,
            'nome' => 'vendas',
            'tipo' => 'entrada'
        ]);

        FinanceiroMovimentacao::create([
            'loja_id' => $pedido->loja_id,
            'categoria_id' => $categoria->id,
            'pedido_id' => $pedido->id,
            'descricao' => "Recebimento Pedido #{$pedido->id}",
            'valor' => $pedido->total,
            'data_vencimento' => now(),
            'data_pagamento' => now(),
        ]);
    }

    private function baixarEstoquePedido(Pedido $pedido)
    {
        DB::transaction(function () use ($pedido) {
            foreach ($pedido->items as $item) {
                if ($item->estoque) {
                    $item->estoque->decrement('quantidade', $item->quantidade);
                }
            }
        });
    }

    private function processarCancelamento(Pedido $pedido)
    {
        $statusAnterior = $pedido->getOriginal('status');

        // A. Estorno Financeiro (Se o status anterior era 'pago')
        if ($statusAnterior === 'pago') {
            $this->registrarEstornoFinanceiro($pedido);
        }

        // B. Retorno de Estoque (Se já estava em produção ou posterior)
        // $statusQueSubtraemEstoque = ['em_producao', 'concluido', 'entregue'];
        // if (in_array($statusAnterior, $statusQueSubtraemEstoque)) {
        //     $this->retornarEstoquePedido($pedido);
        // }
    }

    private function registrarEstornoFinanceiro(Pedido $pedido)
    {
        // Buscamos ou criamos uma categoria de estorno/saída
        $categoria = FinanceiroCategoria::firstOrCreate([
            'loja_id' => $pedido->loja_id,
            'nome' => 'estorno',
            'tipo' => 'saida'
        ]);

        FinanceiroMovimentacao::create([
            'loja_id' => $pedido->loja_id,
            'categoria_id' => $categoria->id,
            'pedido_id' => $pedido->id,
            'descricao' => "Estorno do valor Pago do pedido #{$pedido->id}",
            'valor' => $pedido->total,
            'data_vencimento' => now(),
            'data_pagamento' => now(),
        ]);
    }

    private function retornarEstoquePedido(Pedido $pedido)
    {
        $statusAnterior = $pedido->getOriginal('status');
        $statusQueSubtraemEstoque = ['em_producao', 'concluido', 'entregue'];

        if (in_array($statusAnterior, $statusQueSubtraemEstoque)) {
            DB::transaction(function () use ($pedido) {
                foreach ($pedido->items as $item) {
                    if ($item->estoque) {
                        $item->estoque->increment('quantidade', $item->quantidade);
                    }
                }
            });
        }
    }
}
