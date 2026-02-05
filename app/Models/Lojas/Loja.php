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

    protected $fillable = [
        'nome',
        'slug',
        'cnpj',
        'expira_em'
    ];

    protected function casts(): array
    {
        return [
            'expira_em' => 'datetime:d-m-Y H:i:s',
        ];
    }

    public function lojistas()
    {
        return $this->hasMany(Lojista::class, 'loja_id');
    }

    public function cargos() {
        return $this->hasMant(Cargo::class, 'loja_id');
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
}
