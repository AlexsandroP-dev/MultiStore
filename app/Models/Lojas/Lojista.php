<?php

namespace App\Models\Lojas;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Lojista extends Model
{
    use HasUuids;

    protected $table = 'lojistas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'loja_id',
        'cargo_id',
        'ativo'
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function loja() {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cargos() {
        return $this->hasMany(CargosLojista::class, 'lojista_id');
    }
}
