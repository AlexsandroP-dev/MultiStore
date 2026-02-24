<?php

namespace App\Http\Requests\Lojas\Financeiro;

use Illuminate\Foundation\Http\FormRequest;

class FinanceiroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => ['required','exists:financeiro_categorias,id'],
            'pedido_id'    => ['nullable','exists:pedidos,id'],
            'descricao'    => ['nullable','string','max:255'],
            'valor'        => ['required','numeric','min:0.01'],
            'data_vencimento' => ['required','date'],
            'data_pagamento'  => ['nullable','date'],
        ];
    }
}
