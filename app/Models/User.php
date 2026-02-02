<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Lojas\Lojista;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'cpf',
        'cnpj',
        'admin',
        'administrativo',
        'lojista',
        'colaborador',
        'cliente'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin' => 'boolean',
            'administrativo' => 'boolean',
            'lojista' => 'boolean',
            'colaborador' => 'boolean',
            'cliente' => 'boolean',
        ];
    }

    public function lojistas () {
        return $this->hasMany(Lojista::class, 'user_id');
    }
}
