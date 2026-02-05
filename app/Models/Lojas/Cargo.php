<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasUuids;

    protected $table = 'cargos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'loja_id',
        'nome'
    ];

    public function loja() {
        return $this->belongsTo(Lojista::class, 'loja_id');
    }
}
