<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasUuids;

    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'loja_id',
    ];

    public function loja()
    {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_id');
    }
}
