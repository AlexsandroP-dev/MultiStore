<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
    use HasUuids;

    protected $table = 'lojas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'expira_em' => 'datetime:d-m-Y H:i',
        ];
    }

    public function lojistas()
    {
        return $this->hasMany(Lojista::class, 'loja_id');
    }
}
