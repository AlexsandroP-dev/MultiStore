<?php

namespace App\Models\Clientes;

use App\Models\Lojas\Estoque;
use App\Models\Lojas\Loja;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    //O carrinho é temporário, ao finalizar compra o carrinho será excluído
    use HasUuids;

    protected $table = 'carrinhos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'loja_id',
        'estoque_id',
        // Quantidade em decimal também para caso a medida requerer, por exemplo m2, kg
        'quantidade',
    ];

    protected function casts(): array
    {
        return [
            'quantidade' => 'decimal:2',
        ];
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loja()
    {
        return $this->belongsTo(Loja:: class, 'loja_id');
    }

    public function estoque()
    {
        return $this->belongsTo(Estoque::class, 'estoque_id');
    }
}
