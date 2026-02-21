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
        'slug',
        'ativo',
        'loja_id',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // Regex para validar se a string é um UUID
        $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value);

        return $this->where('loja_id', session('loja_id'))
            ->orWhere(function ($query) use ($value, $isUuid) {
                if ($isUuid) {
                    $query->where('id', $value);
                }
                $query->orWhere('slug', $value);
            })
            ->firstOrFail();
    }

    public function loja()
    {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_id');
    }
}
