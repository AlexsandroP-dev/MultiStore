@extends('layouts.lojas.page')

@section('content')
    @include('utils.layout.indexHeader', [
        'route' => $bag['route'],
        'params' => ['loja' => session('loja_slug')],
    ])
    @include('utils.layout.alertsCustom')
    @if (session('loja_colaboradores_visualizacao', 'tabela') == 'grid')
        <div class="row g-3">
            @foreach ($colaboradores as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        {{-- @if ($item->diretorio_imagem)
                            <img src="{{ asset('storage/' . $item->diretorio_imagem) }}" alt="{{ $item->nome }}"
                                class="img-thumbnail rounded shadow-sm d-block mx-auto"
                                style="width: 180px; height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item->nome }}</h5>
                            <p class="card-text text-muted mb-2" style="font-size: 0.875rem;">Categoria:
                                #{{ $item->categoria->nome }}</p>
                            <div class="mt-auto">
                                @include('utils.buttons.show', [
                                    'route' => $bag['route'],
                                    'params' => [
                                        'loja' => session('loja_slug'),
                                        'categoria' => $item->categoria->slug,
                                        'produto' => $item->slug,
                                    ],
                                ])
                                @include('utils.buttons.edit', [
                                    'route' => $bag['route'],
                                    'params' => [
                                        'loja' => session('loja_slug'),
                                        'categoria' => $item->categoria->slug,
                                        'produto' => $item->slug,
                                    ],
                                ])
                            </div>
                        </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">Colaboradores Vinculados</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalColaborador"
                    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'"
                    onmouseout="this.style.transform='scale(1)'">
                    <i class="bi bi-person-plus me-1"></i> Gerenciar Colaboradores
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-wrap mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Nome</th>
                                <th>E-mail</th>
                                <th>Tipo</th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        Cargo/Função
                                        <button type="button" class="btn btn-xs btn-outline-secondary border-0 p-0 ms-1"
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
                            @foreach ($colaboradores as $item)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $rotaStatus = $item->ativo
                                                    ? route($bag['route'] . '.inativar', [
                                                        'loja' => session('loja_slug'),
                                                        'colaborador' => $item->user_id,
                                                    ])
                                                    : route($bag['route'] . '.reativar', [
                                                        'loja' => session('loja_slug'),
                                                        'colaborador' => $item->user_id,
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
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close" style="transition: transform 0.2s;"
                                                            onmouseover="this.style.transform='scale(1.2)'"
                                                            onmouseout="this.style.transform='scale(1)'"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route($bag['route'] . '.atribuirCargo', ['loja' => session('loja_slug'), 'colaborador' => $item->id]) }}"
                                                        method="POST">
                                                        @csrf

                                                        <div class="modal-body p-0">
                                                            <div class="list-group list-group-flush">
                                                                @forelse($cargos as $cargoDaLoja)
                                                                    <label
                                                                        class="list-group-item d-flex justify-content-between align-items-center py-2 px-3 cursor-pointer">
                                                                        <span
                                                                            class="small text-dark">{{ $cargoDaLoja->nome }}</span>
                                                                        <input class="form-check-input me-1" type="checkbox"
                                                                            name="cargos[]" value="{{ $cargoDaLoja->id }}"
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

                                                        @if ($cargos->count() > 0)
                                                            <div class="modal-footer bg-light border-0 py-2">
                                                                <button type="submit" class="btn btn-sm btn-success w-100"
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
                                    {{-- <td class="text-center">
                                        @include('utils.buttons.show', [
                                            'route' => $bag['route'],
                                            'params' => [
                                                'loja' => session('loja_slug'),
                                                'categoria' => $item->categoria->slug,
                                                'produto' => $item->slug,
                                            ],
                                        ])
                                        @include('utils.buttons.edit', [
                                            'route' => $bag['route'],
                                            'params' => [
                                                'loja' => session('loja_slug'),
                                                'categoria' => $item->categoria->slug,
                                                'produto' => $item->slug,
                                            ],
                                        ])
                                    </td> --}}
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-link text-muted"><i class="bi bi-eye"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="modalColaborador" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Gerenciar Colaborador</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'"
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
                                data-bs-target="#pills-vincular" type="button" role="tab">Vincular Usuário
                                Existente</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-novo" role="tabpanel">
                            <form action="{{ route($bag['route'] . '.store', ['loja' => session('loja_slug')]) }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Nome Completo</label>
                                    <input type="text" name="nome"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        placeholder="Ex: João Silva" value="{{ old('nome') }}" required>
                                    @include('utils.form.error', ['param' => 'nome'])
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">E-mail</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="joao@email.com" value="{{ old('email') }}" required>
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
                                <button type="submit" class="btn btn-success w-100" style="transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.02)'"
                                    onmouseout="this.style.transform='scale(1)'">Criar Colaborador
                                    e
                                    Vincular à Loja</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-vincular" role="tabpanel">
                            <form action="{{ route($bag['route'] . '.vincular', ['loja' => session('loja_slug')]) }}"
                                method="POST">
                                @csrf
                                <div class="mb-3 text-center">
                                    <p class="text-muted small">Digite o e-mail do usuário que já
                                        possui cadastro no sistema para adicioná-lo à loja
                                        **{{ session('loja_nome') }}**.</p>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">E-mail do Usuário</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="buscar@email.com" value="{{ old('email') }}" required>
                                    </div>
                                    @include('utils.form.error', ['param' => 'email'])
                                </div>
                                <button type="submit" class="btn btn-success w-100" style="transition: transform 0.2s;"
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
                        @forelse($cargos ?? [] as $cargo)
                            <div class="list-group-item p-0">
                                <div class="d-flex justify-content-between align-items-center py-3 px-3">
                                    <div>
                                        <span class="fw-semibold d-block text-dark">{{ $cargo->nome }}</span>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-link text-primary p-1"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseEditCargo{{ $cargo->id }}"
                                            style="transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.23)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form
                                            action="{{ route($bag['routeCargo'] . '.destroy', ['loja' => session('loja_slug'), 'cargo' => $cargo->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Deseja realmente excluir este cargo?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-link text-danger p-1"
                                                style="transition: transform 0.2s;"
                                                onmouseover="this.style.transform='scale(1.23)'"
                                                onmouseout="this.style.transform='scale(1)'">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="collapse" id="collapseEditCargo{{ $cargo->id }}">
                                    <div class="bg-light border-top p-2">
                                        <form
                                            action="{{ route($bag['routeCargo'] . '.update', ['loja' => session('loja_slug'), 'cargo' => $cargo->id]) }}"
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
                        <form action="{{ route($bag['routeCargo'] . '.store', ['loja' => session('loja_id')]) }}"
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
    @include('utils.layout.pagination', ['items' => $colaboradores])
@endsection

@push('scripts')
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
