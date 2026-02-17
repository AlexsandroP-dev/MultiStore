<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CargosLojista extends Model
{
    use HasUuids;

    protected $table = 'cargos_lojistas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'cargo_id',
        'lojista_id'
    ];

    public function lojista()
    {
        return $this->belongsTo(Lojista::class, 'lojista_id');
    }

    public function cargo() {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}
