<?php

namespace App\Http\Requests\Main\Lojas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ColaboradorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'    => ['sometimes', 'required', 'max:255'],
            'email'   => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                $this->has('nome') ? 'unique:users,email' : ''
            ],
            'password' => [
                $this->has('nome') ? 'required' : 'nullable',
                $this->has('nome') ? 'confirmed' : '',
                $this->has('nome') ? 'min:8' : '',
                Password::defaults()
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já está cadastrado. Tente a aba "Vincular Existente".',
            'email.exists' => 'Este e-mail não foi encontrado no sistema.',
        ];
    }
}
