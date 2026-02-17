<?php

namespace App\Models\Financeiro;

use App\Models\Lojas\Financeiro\FinanceiroMovimentacao;
use App\Models\Lojas\Loja;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FinanceiroCategoria extends Model
{
    use HasUuids;

    protected $table = 'financeiro_categorias';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'loja_id',
        'nome', //Nome da categoria, ex: vendas, marketing, manutenção, reposição de estoque, investimento, etc.
        'tipo', // Entrada ou saída
    ];

    public function loja()
    {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(FinanceiroMovimentacao::class, 'categoria_id');
    }
}
