@extends('layouts.page')

@section('content')
    <div class="container-fluid py-4">
        @include('utils.layout.alertsCustom')
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-warning">Informações da Loja</h5>
                        <a href="{{ route($bag['route'] . '.edit', $loja->id) }}" class="btn btn-sm btn-outline-warning border-warning" title="Editar"
                            style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
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
                                    <a href="{{ $loja->url() }}" target="_blank"
                                        class="text-decoration-none overflow-hidden flex-grow-1"
                                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.01)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <code class="bg-light p-2 rounded text-primary border d-block"
                                            style="white-space: nowrap; overflow-x: auto; font-size: 0.85rem;">
                                            {{ $loja->url() }}
                                        </code>
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary ms-2 flex-shrink-0"
                                        onclick="copyToClipboard('{{ $loja->url() }}', this)"
                                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'"
                                        onmouseout="this.style.transform='scale(1)'" title="Copiar Link">
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
                                        aria-expanded="false" style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'">
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
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.03)'"
                                                    onmouseout="this.style.transform='scale(1)'">
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
                            @if ($loja->diretorio_logo)
                                <img src="{{ asset('storage/' . $loja->diretorio_logo) }}" class="img-thumbnail shadow-sm"
                                    style="object-fit: cover;">
                            @else
                                <i class="bi bi-shop fs-1"></i>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-1">{{ $loja->nome }}</h6>
                        <p class="text-muted small mb-3">ID: {{ $loja->id }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route($bag['routeLojista'] . '.index', ['loja' => $loja->slug]) }}"
                                class="btn btn-primary btn-sm" style="transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.02)'"
                                onmouseout="this.style.transform='scale(1)'"> Acessar Painel da Loja
                            </a>
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
                            data-bs-target="#modalColaborador" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-person-plus me-1"></i> Gerenciar Colaboradores
                        </button>

                        <div class="modal fade" id="modalColaborador" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Gerenciar Colaborador</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close" style="transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.2)'"
                                            onmouseout="this.style.transform='scale(1)'"></button>
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
                                                    <button type="submit" class="btn btn-success w-100"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.02)'"
                                                        onmouseout="this.style.transform='scale(1)'">Criar Colaborador
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
                                                    <button type="submit" class="btn btn-success w-100"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.02)'"
                                                        onmouseout="this.style.transform='scale(1)'">Localizar e
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
                                        <th>
                                            <div class="d-flex align-items-center">
                                                Cargo/Função
                                                <button type="button"
                                                    class="btn btn-outline-secondary border-0 p-0 ms-1"
                                                    data-bs-toggle="modal" data-bs-target="#modalListaCargos"
                                                    title="Gerenciar Cargos" style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.2)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                                    <i class="bi bi-gear-fill small"></i>
                                                </button>
                                            </div>
                                        </th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($loja->lojistas as $item)
                                        <tr>
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $rotaStatus = $item->ativo
                                                            ? route($bag['routeColaborador'] . '.inativar', [
                                                                'loja' => $loja->id,
                                                                'user' => $item->user_id,
                                                            ])
                                                            : route($bag['routeColaborador'] . '.reativar', [
                                                                'loja' => $loja->id,
                                                                'user' => $item->user_id,
                                                            ]);
                                                        $acaoTexto = $item->ativo ? 'Desativar' : 'Reativar';
                                                    @endphp
                                                    <form action="{{ $rotaStatus }}" method="POST"
                                                        id="form-status-{{ $item->user_id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn p-0 border-0 bg-transparent"
                                                            onclick="confirmarTrocaStatus('{{ $acaoTexto }}', '{{ $item->user->nome }}', '{{ $item->user_id }}')"
                                                            title="{{ $acaoTexto }} Colaborador">
                                                            <div class="avatar-sm {{ $item->ativo ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $item->ativo ? 'text-success' : 'text-danger' }} rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 32px; height: 32px; border: 1px solid {{ $item->ativo ? '#198754' : '#dc3545' }}; transition: transform 0.2s;"
                                                                onmouseover="this.style.transform='scale(1.1)'"
                                                                onmouseout="this.style.transform='scale(1)'">
                                                                {{ strtoupper(substr($item->user->nome, 0, 1)) }}
                                                            </div>
                                                        </button>
                                                    </form>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold text-dark">{{ $item->user->nome }}</span>
                                                        <small class="text-muted" style="font-size: 0.75rem;">ID:
                                                            #{{ $item->user_id }}</small>
                                                    </div>
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
                                            <td>
                                                @php
                                                    $cargosAtribuidosIds = $item->cargos->pluck('cargo_id')->toArray();
                                                @endphp

                                                @if (count($cargosAtribuidosIds) > 0)
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach ($item->cargos as $vinculo)
                                                            <span class="badge bg-light text-primary border cursor-pointer"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalCargosColaborador{{ $item->id }}"
                                                                style="cursor: pointer; transition: transform 0.2s;"
                                                                onmouseover="this.style.transform='scale(1.15)'"
                                                                onmouseout="this.style.transform='scale(1)'">
                                                                {{ $vinculo->cargo->nome }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <a href="javascript:void(0)"
                                                        class="text-primary small text-decoration-none d-inline-block"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCargosColaborador{{ $item->id }}"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-plus-circle me-1"></i> Nenhum cargo atribuído
                                                    </a>
                                                @endif

                                                <div class="modal fade" id="modalCargosColaborador{{ $item->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header bg-light py-2">
                                                                <h6 class="modal-title fw-bold small">Cargos:
                                                                    {{ $item->user->nome }}</h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    style="transition: transform 0.2s;"
                                                                    onmouseover="this.style.transform='scale(1.2)'"
                                                                    onmouseout="this.style.transform='scale(1)'"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route($bag['routeColaborador'] . '.atribuirCargo', ['loja' => $loja->id, 'lojista' => $item->id]) }}"
                                                                method="POST">
                                                                @csrf

                                                                <div class="modal-body p-0">
                                                                    <div class="list-group list-group-flush">
                                                                        @forelse($loja->cargos as $cargoDaLoja)
                                                                            <label
                                                                                class="list-group-item d-flex justify-content-between align-items-center py-2 px-3 cursor-pointer">
                                                                                <span
                                                                                    class="small text-dark">{{ $cargoDaLoja->nome }}</span>
                                                                                <input class="form-check-input me-1"
                                                                                    type="checkbox" name="cargos[]"
                                                                                    value="{{ $cargoDaLoja->id }}"
                                                                                    {{ in_array($cargoDaLoja->id, $cargosAtribuidosIds) ? 'checked' : '' }}>
                                                                            </label>
                                                                        @empty
                                                                            <div class="p-4 text-center">
                                                                                <p class="text-muted small mb-0">
                                                                                    <i
                                                                                        class="bi bi-exclamation-circle d-block mb-1"></i>
                                                                                    Nenhum cargo ou função cadastrada para
                                                                                    esta loja.
                                                                                </p>
                                                                            </div>
                                                                        @endforelse
                                                                    </div>
                                                                </div>

                                                                @if ($loja->cargos->count() > 0)
                                                                    <div class="modal-footer bg-light border-0 py-2">
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-success w-100"
                                                                            style="transition: transform 0.2s;"
                                                                            onmouseover="this.style.transform='scale(1.03)'"
                                                                            onmouseout="this.style.transform='scale(1)'">Atualizar
                                                                            Cargos</button>
                                                                    </div>
                                                                @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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

        <div class="modal fade" id="modalListaCargos" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h6 class="modal-title fw-bold">Gerenciar Cargos da Unidade</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'"
                            onmouseout="this.style.transform='scale(1)'"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                            @forelse($loja->cargos ?? [] as $cargo)
                                <div class="list-group-item p-0">
                                    <div class="d-flex justify-content-between align-items-center py-3 px-3">
                                        <div>
                                            <span class="fw-semibold d-block text-dark">{{ $cargo->nome }}</span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-warning border-warning" title="Editar"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseEditCargo{{ $cargo->id }}"
                                                style="transition: transform 0.2s;"
                                                onmouseover="this.style.transform='scale(1.15)'"
                                                onmouseout="this.style.transform='scale(1)'">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form
                                                action="{{ route($bag['routeCargo'] . '.destroy', ['loja' => $loja->id, 'cargo' => $cargo->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Deseja realmente excluir este cargo?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-danger" title="Excluir"
                                                    style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.15)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collapseEditCargo{{ $cargo->id }}">
                                        <div class="bg-light border-top p-2">
                                            <form
                                                action="{{ route($bag['routeCargo'] . '.update', ['loja' => $loja->id, 'cargo' => $cargo->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="nome" class="form-control"
                                                        value="{{ $cargo->nome }}" required>
                                                    <button class="btn btn-success" type="submit"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseEditCargo{{ $cargo->id }}"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-briefcase fs-2 d-block mb-2"></i>
                                    Nenhum cargo cadastrado.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-2">
                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="collapse"
                            data-bs-target="#collapseNovoCargo" aria-expanded="false" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-plus-lg me-1"></i> Adicionar Novo Cargo
                        </button>
                    </div>
                    <div class="collapse" id="collapseNovoCargo">
                        <div class="card-body bg-light border-bottom p-3">
                            <form action="{{ route($bag['routeCargo'] . '.store', ['loja' => $loja->id]) }}"
                                method="POST">
                                @csrf

                                <div class="input-group input-group-sm">
                                    <input type="text" name="nome" class="form-control"
                                        placeholder="Nome do cargo (ex: Gerente)" required>
                                    <button class="btn btn-success" type="submit" style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-check-lg"></i> Salvar
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseNovoCargo" style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
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

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalColaborador'));
                myModal.show();
            });
        </script>
    @endif

    <script>
        function confirmarTrocaStatus(acao, nome, id) {
            const msg = `Deseja realmente ${acao} o colaborador ${nome}?`;

            if (confirm(msg)) {
                const form = document.getElementById(`form-status-${id}`);
                if (form) {
                    form.submit();
                } else {
                    console.error("Formulário não encontrado: form-status-" + id);
                }
            }
        }
    </script>
@endpush
