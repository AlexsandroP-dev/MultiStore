<?php

namespace App\Models\Lojas\Financeiro;

use App\Models\Clientes\Pedido;
use App\Models\Lojas\Financeiro\FinanceiroCategoria;
use App\Models\Lojas\Loja;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FinanceiroMovimentacao extends Model
{
    use HasUuids;

    protected $table = 'financeiro_movimentacoes';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'loja_id',
        'categoria_id',
        // Relacionamento opcional pois se a entrada vier de um produto então será vinculada aqui
        // nem todas as entradas serão de produtos
        'pedido_id',
        'descricao', //Exemplo: #pedido->id, "Pagamento de Aluguel mês/ano
        'valor',
        'data_vencimento',
        'data_pagamento' //Caso for nulo então é uma conta a pagar ou dinheiro a receber
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'data_vencimento' => 'datetime:d-m-Y',
            'data_pagamento' => 'datetime:d-m-Y',
        ];
    }

    public function loja()
    {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function categoria()
    {
        return $this->belongsTo(FinanceiroCategoria::class, 'categoria_id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
