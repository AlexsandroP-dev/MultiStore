<?php

namespace App\Models\Lojas;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'diretorio_imagem',
        'slug'
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        $query = $this->newQuery();
        $lojaId = session('loja_id');

        if ($lojaId) {
            $query->where('loja_id', $lojaId);
        } else {
            $lojaParam = request()->route('loja');
            if ($lojaParam instanceof \App\Models\Lojas\Loja) {
                $query->where('loja_id', $lojaParam->id);
            } else {
                $query->whereHas('loja', function ($q) use ($lojaParam) {
                    $q->where('slug', $lojaParam);
                });
            }
        }

        $isUuid = Str::isUuid($value);
        return $query->where(function ($q) use ($value, $isUuid) {
            if ($isUuid) {
                $q->where('id', $value);
            } else {
                $q->where('slug', $value);
            }
        })->firstOrFail();
    }

    public function loja()
    {
        return $this->belongsTo(Loja::class, 'loja_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class, 'produto_id');
    }
}
