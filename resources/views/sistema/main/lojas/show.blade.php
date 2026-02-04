@extends('layouts.page')

@section('content')
    <div class="container-fluid py-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <strong class="d-block">Ops! Algo deu errado:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                <div class="card shadow-sm border-0 border-top border-primary border-3 mb-4">
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
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalColaborador">
                            <i class="bi bi-person-plus me-1"></i> Gerenciar Colaboradores
                        </button>

                        <div class="modal fade" id="modalColaborador" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Gerenciar Colaborador</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="nav nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="tab-novo" data-bs-toggle="pill"
                                                    data-bs-target="#pills-novo" type="button" role="tab">Criar
                                                    Novo Usuário</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="tab-vincular" data-bs-toggle="pill"
                                                    data-bs-target="#pills-vincular" type="button"
                                                    role="tab">Vincular Usuário Existente</button>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="pills-novo" role="tabpanel">
                                                <form
                                                    action="{{ route($bag['routeColaborador'] . '.store', ['loja' => $loja->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Nome Completo</label>
                                                        <input type="text" name="nome"
                                                            class="form-control @error('nome') is-invalid @enderror"
                                                            placeholder="Ex: João Silva" value="{{ old('nome') }}"
                                                            required>
                                                        @include('utils.form.error', ['param' => 'nome'])
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">E-mail</label>
                                                        <input type="email" name="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            placeholder="joao@email.com" value="{{ old('email') }}"
                                                            required>
                                                        @include('utils.form.error', ['param' => 'email'])
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Senha Temporária</label>
                                                        <input type="password" name="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            placeholder="Mínimo 8 caracteres" required>
                                                        @include('utils.form.error', [
                                                            'param' => 'password',
                                                        ])
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Confirmar Senha</label>
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            placeholder="Mínimo 8 caracteres" required>
                                                        @include('utils.form.error', [
                                                            'param' => 'password_confirmation',
                                                        ])
                                                    </div>
                                                    <button type="submit" class="btn btn-success w-100">Criar Colaborador
                                                        e
                                                        Vincular à Loja</button>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="pills-vincular" role="tabpanel">
                                                <form
                                                    action="{{ route($bag['routeColaborador'] . '.vincular', ['loja' => $loja->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="mb-3 text-center">
                                                        <p class="text-muted small">Digite o e-mail do usuário que já
                                                            possui cadastro no sistema para adicioná-lo à loja
                                                            **{{ $loja->nome }}**.</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label small fw-bold">E-mail do Usuário</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-envelope"></i></span>
                                                            <input type="email" name="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                placeholder="buscar@email.com"
                                                                value="{{ old('email') }}" required>
                                                        </div>
                                                        @include('utils.form.error', ['param' => 'email'])
                                                    </div>
                                                    <button type="submit" class="btn btn-success w-100">Localizar e
                                                        Vincular à Loja</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                    <div class="avatar-sm @if($item->status === 'Ativo') bg-success @else bg-danger @endif bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px; border: 1px solid; border-color: @if($item->status === 'Ativo') green @else red @endif">
                                                        {{ strtoupper(substr($item->user->nome, 0, 1)) }}
                                                    </div>
                                                    <span class="fw-semibold">{{ $item->user->nome }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $item->user->email }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @if ($item->user->admin)
                                                        <span class="badge bg-dark text-white">Admin</span>
                                                    @endif

                                                    @if ($item->user->administrativo)
                                                        <span class="badge bg-primary">Administrativo</span>
                                                    @endif

                                                    @if ($item->user->lojista)
                                                        <span class="badge bg-info text-dark">Lojista</span>
                                                    @endif

                                                    @if ($item->user->colaborador)
                                                        <span class="badge bg-secondary">Colaborador</span>
                                                    @endif

                                                    @if (!($item->user->admin || $item->user->administrativo || $item->user->lojista || $item->user->colaborador))
                                                        <span class="text-muted small">Sem tipo definido</span>
                                                    @endif
                                                </div>
                                            </td>
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
                                            <td colspan="5" class="text-center py-4 text-muted">
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

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalColaborador'));
                myModal.show();
            });
        </script>
    @endif
@endpush
