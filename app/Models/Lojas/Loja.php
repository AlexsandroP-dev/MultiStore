<?php

namespace App\Models\Lojas;

use App\Models\Clientes\Pedido;
use App\Models\Financeiro\FinanceiroCategoria;
use App\Models\Lojas\Financeiro\FinanceiroMovimentacao;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Loja extends Model
{
    use HasUuids;

    protected $table = 'lojas';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'slug',
        'cnpj',
        'contato',
        'expira_em',
        'diretorio_logo'
    ];

    protected function casts(): array
    {
        return [
            'expira_em' => 'datetime:d-m-Y H:i:s',
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $isUuid = Str::isUuid($value);
        return $this->where(function ($query) use ($value, $isUuid) {
            $query->where(function ($q) use ($value, $isUuid) {
                if ($isUuid) {
                    $q->where('id', $value);
                } else {
                    $q->where('slug', $value);
                }
            });
        })->firstOrFail();
    }

    public function lojistas()
    {
        return $this->hasMany(Lojista::class, 'loja_id');
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class, 'loja_id');
    }

    public function cnpj(): string
    {
        if (!$this->cnpj) {
            return 'Não informado';
        }

        // Formata 00000000000000 para 00.000.000/0000-00
        return preg_replace(
            "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/",
            "$1.$2.$3/$4-$5",
            $this->cnpj
        );
    }

    public function isActive(): bool
    {
        return $this->expira_em && $this->expira_em->isFuture();
    }

    public function url(): string
    {
        $base = strtolower(config('themes.mainTheme.base.HeaderTitle'));
        return "https://{$base}.com/loja/{$this->slug}";
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'loja_id');
    }

    public function financeiro_categoria()
    {
        return $this->hasMany(FinanceiroCategoria::class, 'loja_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(FinanceiroMovimentacao::class, 'loja_id');
    }
}
