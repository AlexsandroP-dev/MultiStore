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
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <p class="text-dark mb-0 fw-semibold">
                                        {{ $loja->expira_em->format('d/m/Y H:i') }}
                                    </p>

                                    @if ($loja->isActive())
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle px-2">Ativo</span>
                                    @else
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">Expirado</span>
                                    @endif

                                    <button class="btn btn-sm btn-link text-primary p-0 ms-2 text-decoration-none"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseRenovacao"
                                        aria-expanded="false">
                                        <i class="bi bi-plus-circle me-1"></i>Adicionar meses
                                    </button>
                                </div>
                                <div class="collapse mt-3" id="collapseRenovacao">
                                    <div class="card card-body bg-light border-0 shadow-sm">
                                        <form action="{{ route($bag['route'] . '.update.renew', $loja->id) }}"
                                            method="POST" class="row g-2 align-items-center">
                                            @csrf
                                            @method('PUT')

                                            <div class="col-auto">
                                                <label class="visually-hidden">Meses</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="expira_em" class="form-control"
                                                        placeholder="Qtd. Meses" required>
                                                    <span class="input-group-text">meses</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check-lg"></i> Confirmar Renovação
                                                </button>
                                            </div>
                                        </form>
                                        <small class="text-muted mt-2">A nova validade será somada à atual e definida para
                                            as 23:55.</small>
                                    </div>
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
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary">Colaboradores Vinculados</h5>
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="bi bi-person-plus me-1"></i> Novo Colaborador
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Nome</th>
                                        <th>E-mail</th>
                                        <th>Tipo</th>
                                        <th>Cargo/Função</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($loja->lojistas as $item)
                                        <tr>
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        {{ strtoupper(substr($item->user->nome, 0, 1)) }}
                                                    </div>
                                                    <span class="fw-semibold">{{ $item->user->nome }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $item->user->email }}</td>
                                            <td>{{ $item->user->lojista }}</td>
                                            <td><span class="badge bg-light text-muted border">Colaborador</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-link text-muted"><i
                                                        class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-link text-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                                Nenhum colaborador cadastrado para esta loja.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
