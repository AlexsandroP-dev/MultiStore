@extends('layouts.page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-primary">Editar Loja: {{ $loja->nome }}</h5>
                            <small class="text-muted">Atualize as configurações da unidade abaixo.</small>
                        </div>
                        <span class="badge {{ $loja->expira_em->isFuture() ? 'bg-success' : 'bg-danger' }}">
                            Expira em: {{ $loja->expira_em->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route($bag['route'] . '.update', $loja->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="nome" class="form-label fw-semibold">Razão Social</label>
                                    <input type="text" name="nome" id="nome"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        placeholder="Ex: Minha Loja Matriz LTDA" value="{{ old('nome', $loja->nome) }}"
                                        required>
                                    @include('utils.form.error', ['param' => 'nome'])
                                </div>
                                <div class="col-md-6">
                                    <label for="slug" class="form-label fw-semibold">URL de Acesso (Slug)</label>
                                    <div class="input-group d-flex flex-column flex-md-row">
                                        <span class="input-group-text bg-light text-muted border-column-fix">
                                            {{ strtolower(config('themes.mainTheme.base.HeaderTitle')) }}.com/loja/
                                        </span>
                                        <input type="text" name="slug" id="slug"
                                            class="form-control w-100 input-column-fix @error('slug') is-invalid @enderror"
                                            placeholder="minha-loja" value="{{ old('slug', $loja->slug) }}" required>
                                    </div>
                                    @include('utils.form.error', ['param' => 'slug'])
                                    <small class="text-muted">Apenas letras minúsculas, números e hífens.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="cnpj" class="form-label fw-semibold">CNPJ (Opcional)</label>
                                    <input type="text" name="cnpj" id="cnpj"
                                        class="form-control @error('cnpj') is-invalid @enderror"
                                        placeholder="00.000.000/0000-00" value="{{ old('cnpj', $loja->cnpj) }}">
                                    @include('utils.form.error', ['param' => 'cnpj'])
                                </div>
                                <div class="col-md-6">
                                    <label for="expira_em" class="form-label fw-semibold">Adicionar Tempo de Validade
                                        (Meses)</label>
                                    <input type="number" name="expira_em" id="expira_em"
                                        class="form-control @error('expira_em') is-invalid @enderror"
                                        placeholder="Quantidade de meses para somar" value="{{ old('expira_em') }}">
                                    @include('utils.form.error', ['param' => 'expira_em'])
                                    <small class="text-info">
                                        <i class="bi bi-info-circle me-1"></i>
                                        A quantidade informada será somada à validade atual.
                                    </small>
                                </div>
                            </div>
                            <hr class="my-4 text-muted">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route($bag['route'] . '.index') }}" class="btn btn-light border">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Atualizar Dados
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        @media (max-width: 767.98px) {
            .border-column-fix {
                border-radius: 0.375rem 0.375rem 0 0 !important;
                border-bottom: none !important;
                width: 100%;
            }

            .input-column-fix {
                border-radius: 0 0 0.375rem 0.375rem !important;
                width: 100%;
            }
        }

        @media (min-width: 768px) {
            .input-group.flex-md-row {
                flex-wrap: nowrap !important;
            }

            .border-column-fix {
                border-radius: 0.375rem 0 0 0.375rem !important;
                width: auto;
            }

            .input-column-fix {
                border-radius: 0 0.375rem 0.375rem 0 !important;
                flex: 1 1 auto;
                width: 1%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        const cnpjInput = document.getElementById('cnpj');
        const formatCNPJ = (val) => {
            let value = val.replace(/\D/g, '');
            if (value.length > 14) value = value.slice(0, 14);
            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            return value;
        };

        if (cnpjInput.value) cnpjInput.value = formatCNPJ(cnpjInput.value);

        cnpjInput.addEventListener('input', (e) => {
            e.target.value = formatCNPJ(e.target.value);
        });

        // Slug (desabilitado por padrão no edit para evitar quebra de SEO, 
        // mas deixamos o script caso o usuário apague e queira gerar de novo)
        const nomeInput = document.getElementById('nome');
        const slugInput = document.getElementById('slug');

        nomeInput.addEventListener('input', () => {
            if (slugInput.value === '') { // Só gera se estiver vazio
                const value = nomeInput.value;
                const slug = value.toLowerCase()
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "")
                    .replace(/[^a-z0-9]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                slugInput.value = slug;
            }
        });
    </script>
@endpush
