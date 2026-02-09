<?php

namespace App\Models\Clientes;

use App\Models\Lojas\Lojista;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PedidoStatusHistorico extends Model
{
    use HasUuids;

    protected $table = 'pedido_status_historicos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pedido_id',
        // Quem alterou? sistema ou algum colaborador
        'lojista_id',
        'status_anterior',
        'status_novo',
        'comentario',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function lojista()
    {
        return $this->belongsTo(Lojista::class, 'lojista_id');
    }
}
