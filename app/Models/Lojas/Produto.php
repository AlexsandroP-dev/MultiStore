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
        'diretorio_imagem',
        'slug'
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        // Regex para validar se a string é um UUID
        $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value);

        return $this->where('loja_id', session('loja_id'))
            ->where(function ($query) use ($value, $isUuid) {
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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function estoques()
    {
        return $this->hasMany(Estoque::class, 'produto_id');
    }
}
