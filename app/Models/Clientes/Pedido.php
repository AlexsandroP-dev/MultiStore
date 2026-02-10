<?php

namespace App\Models\Clientes;

use App\Models\Lojas\Loja;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasUuids;

    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'loja_id',
        'total',
        // Status: 'pendente', 'pago', 'em_producao', 'concluido', 'entregue', 'cancelado'
        'status',
        // Metodo_entrega: 'Retirada', 'Transportadora', 'Uber', etc
        'metodo_entrega',
        'valor_frete',
        'text'
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'valor_frete' => 'decimal:2',
        ];
    }

    public const STATUS_PENDENTE    = 'pendente';
    public const STATUS_PAGO        = 'pago';
    public const STATUS_PRODUCAO    = 'em_producao';
    public const STATUS_CONCLUIDO   = 'concluido'; // Pronto para entrega/retirada
    public const STATUS_ENTREGUE    = 'entregue';
    public const STATUS_CANCELADO   = 'cancelado';

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loja()
    {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function items()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_id');
    }

    public function historicos()
    {
        return $this->hasMany(PedidoStatusHistorico::class, 'pedido_id');
    }
}
