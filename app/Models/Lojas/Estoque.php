<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasUuids;

    protected $table = 'estoques';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'produto_id',
        // Medida: 'unidade', 'm2', 'kg', 'metro', etc
        'medida',
        'preco_venda',
        'preco_custo',
        // Quantidade em decimal também para caso a medida requerer, por exemplo m2, kg
        'quantidade',
        'estoque_minimo',
        'disponivel'
    ];

    protected function casts(): array
    {
        return [
            'preco_venda' => 'decimal:2',
            'preco_custo' => 'decimal:2',
            'quantidade' => 'decimal:2',
            'estoque_minimo' => 'decimal:2',
            'disponivel' => 'boolean'
        ];
    }

    public function preco_venda()
    {
        return number_format($this->preco_venda, 2, ',', '.');
    }

    public function preco_custo()
    {
        return number_format($this->preco_custo, 2, ',', '.');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
