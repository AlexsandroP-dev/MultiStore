@extends('layouts.page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary">Cadastrar Nova Loja</h5>
                        <small class="text-muted">Preencha os dados abaixo para configurar sua unidade.</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route($bag['route'] . '.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="nome" class="form-label fw-semibold">Razão Social</label>
                                    <input type="text" name="nome" id="nome"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        placeholder="Ex: Minha Loja Matriz LTDA" value="{{ old('nome') }}" required>
                                    @include('utils.form.error', ['param' => 'nome'])
                                </div>
                                <div class="col-md-6">
                                    <label for="slug" class="form-label fw-semibold">URL de Acesso (Slug)</label>
                                    {{-- d-flex flex-column (mobile) | flex-md-row (desktop) --}}
                                    <div class="input-group d-flex flex-column flex-md-row">
                                        <span class="input-group-text bg-light text-muted border-column-fix">
                                            {{ strtolower(config('themes.mainTheme.base.HeaderTitle')) }}.com/loja/
                                        </span>
                                        <input type="text" name="slug" id="slug"
                                            class="form-control w-100 input-column-fix @error('slug') is-invalid @enderror"
                                            placeholder="minha-loja" value="{{ old('slug') }}" required>
                                    </div>
                                    @include('utils.form.error', ['param' => 'slug'])
                                    <small class="text-muted">Apenas letras minúsculas, números e hífens.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="cnpj" class="form-label fw-semibold">CNPJ (Opcional)</label>
                                    <input type="text" name="cnpj" id="cnpj"
                                        class="form-control @error('cnpj') is-invalid @enderror"
                                        placeholder="00.000.000/0000-00" minlength="18" value="{{ old('cnpj') }}">
                                    @include('utils.form.error', ['param' => 'cnpj'])
                                    <small class="text-muted">Deixe em branco se não possuir.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="contato" class="form-label fw-semibold">WhatsApp de Contato</label>
                                    <input type="text" name="contato" id="contato"
                                        class="form-control @error('contato') is-invalid @enderror"
                                        placeholder="(00) 00000-0000" value="{{ old('contato') }}">
                                    @include('utils.form.error', ['param' => 'contato'])
                                </div>
                                <div class="col-md-6">
                                    <label for="expira_em" class="form-label fw-semibold">Validade (Meses)</label>
                                    <input type="number" name="expira_em" id="expira_em"
                                        class="form-control @error('expira_em') is-invalid @enderror" placeholder="meses"
                                        value="{{ old('expira_em') }}">
                                    @include('utils.form.error', ['param' => 'expira_em'])
                                    <small class="text-muted">Período de validade da loja.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="diretorio_logo" class="form-label fw-semibold">Logomarca (Opcional)</label>
                                    <input type="file" name="diretorio_logo" id="diretorio_logo"
                                        class="form-control @error('diretorio_logo') is-invalid @enderror">
                                    <div class="form-text small">Formatos: JPG, JPEG ou PNG. Máx: 3MB.</div>
                                    @include('utils.form.error', ['param' => 'diretorio_logo'])
                                </div>
                            </div>
                            @include('utils.form.cancelsubmitbuttons', [
                                'cancel_route' => route($bag['route'] . '.index'),
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
        /* Mobile: Ajustes para o modo empilhado */
        @media (max-width: 767.98px) {
            .border-column-fix {
                border-radius: 0.375rem 0.375rem 0 0 !important;
                border-bottom: none !important;
                width: 100%;
                text-align: left;
                justify-content: flex-start;
            }

            .input-column-fix {
                border-radius: 0 0 0.375rem 0.375rem !important;
                width: 100%;
            }
        }

        /* Desktop: Força o comportamento original do input-group (span ao lado do input) */
        @media (min-width: 768px) {
            .input-group.flex-md-row {
                flex-wrap: nowrap !important;
            }

            .border-column-fix {
                border-radius: 0.375rem 0 0 0.375rem !important;
                border-bottom: 1px solid #dee2e6 !important;
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

        cnpjInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 14) value = value.slice(0, 14);

            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Auto-geração de Slug baseada no nome
        const nomeInput = document.getElementById('nome');
        const slugInput = document.getElementById('slug');

        nomeInput.addEventListener('input', () => {
            const value = nomeInput.value;
            const slug = value.toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            slugInput.value = slug;
        });
    </script>
    <script>
        const contatoInput = document.getElementById('contato');

        contatoInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
            if (value.length > 11) value = value.slice(0, 11);

            // Formatação (XX) XXXXX-XXXX
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length > 6) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else if (value.length > 0) {
                value = value.replace(/^(\d*)/, '($1');
            }
            e.target.value = value;
        });
    </script>
@endpush
