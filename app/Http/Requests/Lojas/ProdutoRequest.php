<?php

namespace App\Http\Requests\Lojas;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['sometimes', 'required', 'string', 'max:255'],
            'nome_categoria' => ['sometimes', 'required', 'string', 'max:255'],
            'categoria_id' => ['sometimes', 'required', 'exists:categorias,id'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'diretorio_imagem' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:3072']
        ];
    }
}
