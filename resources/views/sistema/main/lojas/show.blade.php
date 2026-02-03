@extends('layouts.page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary">Informações da Loja</h5>
                        <a href="{{ route($bag['route'] . '.edit', $loja->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i> Editar
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="text-muted small fw-bold text-uppercase">Razão Social</label>
                                <p class="fs-5 fw-semibold text-dark">{{ $loja->nome }}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="text-muted small fw-bold text-uppercase">URL de Acesso</label>
                                <div class="d-flex align-items-center">
                                    <a href="{{ $loja->url() }}" target="_blank" class="text-decoration-none">
                                        <code class="bg-light p-2 rounded text-primary border">
                                            {{ $loja->url() }}
                                        </code>
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary ms-2"
                                        onclick="copyToClipboard('{{ $loja->url() }}', this)" title="Copiar Link">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="text-muted small fw-bold text-uppercase">CNPJ</label>
                                <p class="text-dark">
                                    {{ $loja->cnpj() }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold text-uppercase">Data de Expiração</label>
                                <div class="d-flex align-items-center">
                                    <p class="text-dark mb-0 me-2">
                                        {{ $loja->expira_em->format('d/m/Y H:i') }}
                                    </p>

                                    @if ($loja->isActive())
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle px-2">Ativo</span>
                                    @else
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">Expirado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-3 border-0">
                        <small class="text-muted">Cadastrada em: {{ $loja->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 border-top border-primary border-3">
                    <div class="card-body text-center py-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-shop fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-1">{{ $loja->nome }}</h6>
                        <p class="text-muted small mb-3">ID: {{ $loja->id }}</p>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-sm">Acessar Painel da Loja</button>
                            <form action="{{ route($bag['route'] . '.destroy', $loja->id) }}" method="POST"
                                onsubmit="return confirm('Deseja excluir esta loja?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="btn btn-link btn-sm text-danger text-decoration-none w-100">Excluir
                                    Registro</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(() => {
                const icon = button.querySelector('i');
                const originalClass = icon.className;
                const originalBtnClass = button.className;

                icon.className = 'bi bi-check-lg';
                button.className = 'btn btn-sm btn-success ms-2';

                setTimeout(() => {
                    icon.className = originalClass;
                    button.className = originalBtnClass;
                }, 2000);
            }).catch(err => {
                console.error('Erro ao copiar: ', err);
                alert('Não foi possível copiar o link automaticamente.');
            });
        }
    </script>
@endpush
