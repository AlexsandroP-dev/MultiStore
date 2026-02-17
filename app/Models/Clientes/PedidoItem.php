<?php

namespace App\Models\Clientes;

use App\Models\Lojas\Estoque;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasUuids;

    protected $table = 'pedido_items';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pedido_id',
        'estoque_id',
        // Registrando os dados redundantemente nesta tabela evita de ter alterações automáticas futuras
        // se as informações em estoque_id forem alteradas
        'produto_nome',
        'medida',
        'quantidade',
        'preco_venda',
        'subtotal'
    ];

    protected function casts(): array
    {
        return [
            'quantidade' => 'decimal:2',
            'preco_venda' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function estoque()
    {
        return $this->belongsTo(Estoque::class, 'estoque_id');
    }
}
