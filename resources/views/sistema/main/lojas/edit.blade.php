@extends('layouts.page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-warning">Editar Loja: {{ $loja->nome }}</h5>
                            <small class="text-muted">Atualize as configurações da unidade abaixo.</small>
                        </div>
                        <span class="badge {{ $loja->expira_em->isFuture() ? 'bg-success' : 'bg-danger' }}">
                            Expira em: {{ $loja->expira_em->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route($bag['route'] . '.update', $loja->id) }}" method="POST"
                            enctype="multipart/form-data">
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
                                    <label for="contato" class="form-label fw-semibold">WhatsApp de Contato</label>
                                    <input type="text" name="contato" id="contato"
                                        class="form-control @error('contato') is-invalid @enderror"
                                        placeholder="(00) 00000-0000" value="{{ old('contato', $loja->contato) }}">
                                    @include('utils.form.error', ['param' => 'contato'])
                                </div>
                                <div class="col-md-6">
                                    <label for="expira_em" class="form-label fw-semibold">Adicionar Tempo de Validade
                                        (Meses)</label>
                                    <input type="number" name="expira_em" id="expira_em"
                                        class="form-control @error('expira_em') is-invalid @enderror"
                                        placeholder="Quantidade de meses para somar" value="{{ old('expira_em') ?? 0 }}">
                                    @include('utils.form.error', ['param' => 'expira_em'])
                                    <small class="text-info">
                                        <i class="bi bi-info-circle me-1"></i>
                                        A quantidade informada será somada à validade atual.
                                    </small>
                                </div>
                                <div class="col-md-12">
                                    <label for="diretorio_logo" class="form-label fw-semibold">Logomarca</label>
                                    <div
                                        class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                                        @if ($loja->diretorio_logo)
                                            <div class="text-center">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $loja->diretorio_logo) }}"
                                                        class="img-thumbnail shadow-sm"
                                                        style="width: 70px; height: 70px; object-fit: cover;">
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark border border-light">
                                                        Atual
                                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex-grow-1 w-100">
                                            <input type="file" name="diretorio_logo" id="diretorio_logo"
                                                class="form-control @error('diretorio_logo') is-invalid @enderror">
                                            <div class="form-text small">Selecione apenas para alterar. JPG, JPEG, PNG (Máx:
                                                3MB).
                                            </div>
                                            @include('utils.form.error', ['param' => 'diretorio_logo'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('utils.form.cancelsubmitbuttons', [
                                'cancel_route' => route($bag['route'] . '.show', ['loja' => $loja->id]),
                            ])
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
    <script>
        const contatoInput = document.getElementById('contato');

        const formatWhatsApp = (val) => {
            let value = val.replace(/\D/g, ''); // Remove caracteres que não são números
            if (value.length > 11) value = value.slice(0, 11);

            if (value.length > 10) {
                return value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length > 6) {
                return value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (value.length > 2) {
                return value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else {
                return value.length > 0 ? '(' + value : value;
            }
        };

        // Formata ao carregar a página
        if (contatoInput.value) {
            contatoInput.value = formatWhatsApp(contatoInput.value);
        }

        // Formata ao digitar
        contatoInput.addEventListener('input', (e) => {
            e.target.value = formatWhatsApp(e.target.value);
        });
    </script>
@endpush
