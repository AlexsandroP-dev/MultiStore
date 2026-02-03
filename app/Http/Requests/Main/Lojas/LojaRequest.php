<?php

namespace App\Http\Requests\Main\Lojas;

use App\Rules\CnpjValidator;
use Illuminate\Foundation\Http\FormRequest;

class LojaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->cnpj) {
            $this->merge([
                // Remover pontos, barra e traço para validar apenas os números
                'cnpj' => preg_replace('/\D/', '', $this->cnpj),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', 'min:3'],
            'slug' => ['required', 'string', 'max:255', 'unique:lojas,slug'],
            'cnpj' => ['nullable', 'string', new CnpjValidator],
            'expira_em' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique'   => 'Esta URL já está em uso.',
        ];
    }
}
