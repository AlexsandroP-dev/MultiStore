<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasUuids;

    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'loja_id',
        'categoria_id',
        'descricao',
        'sku',
        'diretorio_imagem'
    ];

    public function loja()
    {
        return $this->belongsTo(Loja:: class, 'loja_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function estoques()
    {
        return $this->hasMany(Estoque::class, 'produto_id');
    }
}
