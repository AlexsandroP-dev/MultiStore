<?php

namespace App\Http\Requests\Lojas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstoqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medida' => ['required', 'string', Rule::in(['unidade', 'm2', 'kg', 'metro'])],
            'preco_venda' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'preco_custo' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'quantidade' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'estoque_minimo' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
        ];
    }
}
