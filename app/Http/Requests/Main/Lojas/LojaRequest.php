<?php

namespace App\Http\Requests\Main\Lojas;

use App\Rules\CnpjValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $loja = $this->route('loja');
        return [
            'nome' => ['sometimes', 'required', 'string', 'max:255', 'min:3'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('lojas', 'slug')->ignore($loja?->id),],
            'cnpj' => ['nullable', 'string', new CnpjValidator],
            'expira_em' => ['required', 'integer', 'min:0'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        $mesesParaAdicionar = (int) ($validated['expira_em'] ?? $this->expira_em);

        // 1. Verificamos se é um Update e se a loja já possui uma data (ex: $this->loja é o objeto da rota).
        // Se for Create, $dataAtual será null.
        $lojaExistente = $this->route('loja');
        $dataAtual = $lojaExistente ? $lojaExistente->expira_em : null;

        if ($dataAtual && $dataAtual->isFuture()) {
            // Se Já existir data e for maior que hoje então soma a partir da data de expiração atual.
            $novaData = $dataAtual->addMonths($mesesParaAdicionar);
        } else {
            // Se for primeiro registro ou se a data já venceu então soma a partir de agora.
            $novaData = now()->addMonths($mesesParaAdicionar);
        }

        $novaData->setTime(23, 55, 0);

        $validated = array_merge($validated, ['expira_em' => $novaData]);
        return $validated;
    }

    public function messages(): array
    {
        return [
            'slug.unique'   => 'Esta URL já está em uso.',
            'expira_em.required' => 'Informe o tempo de expiração da loja.',
        ];
    }
}
