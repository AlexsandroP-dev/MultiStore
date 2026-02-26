@extends('layouts.lojas.page')

@section('content')
    @include('utils.layout.alertsCustom')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm {{ $saldoAtual >= 0 ? 'bg-primary' : 'bg-danger' }} text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-white-50 d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Saldo
                                Total</small>
                            <h4 class="mb-0 fw-bold">R$ {{ number_format($saldoAtual, 2, ',', '.') }}</h4>
                        </div>
                        <i class="bi bi-piggy-bank fs-3 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Entradas</small>
                    <h4 class="mb-0 text-success fw-bold">R$ {{ number_format($totalEntradas, 2, ',', '.') }}</h4>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body">
                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Saídas</small>
                    <h4 class="mb-0 text-danger fw-bold">R$ {{ number_format($totalSaidas, 2, ',', '.') }}</h4>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-danger" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-light">
                <div class="card-body">
                    <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Pendente
                        (Liquidez)</small>
                    <h4 class="mb-0 {{ $totalPendente >= 0 ? 'text-primary' : 'text-orange' }} fw-bold">
                        R$ {{ number_format($totalPendente, 2, ',', '.') }}
                    </h4>
                    <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">
                        {{ $totalPendente >= 0 ? 'Saldo futuro positivo' : 'Contas a pagar superam as entradas' }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Movimentações</h5>
            <div class="btn-list">
                @include($bag['view'] . '.search')
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCategorias"
                    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'"
                    onmouseout="this.style.transform='scale(1)'">
                    <i class="bi bi-tags"></i> <span class="d-none d-md-inline">Categorias</span>
                </button>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaMovimentacao"
                    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.07)'"
                    onmouseout="this.style.transform='scale(1)'">
                    <i class="bi bi-currency-dollar"></i> <span class="d-none d-md-inline">Nova Movimentação</span>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            {{-- Desktop Header --}}
            <div class="d-none d-md-block bg-light border-bottom py-2 px-4">
                <div class="row fw-bold text-muted small">
                    <div class="col-md-2">Data / Venc.</div>
                    <div class="col-md-4">Descrição / Categoria</div>
                    <div class="col-md-2 text-center">Valor</div>
                    <div class="col-md-2 text-center">Status</div>
                    <div class="col-md-2 text-end">Ações</div>
                </div>
            </div>

            <div class="list-group list-group-flush">
                @foreach ($movimentacoes as $mov)
                    <div class="list-group-item p-3 p-md-4">
                        <div class="row align-items-center g-3">
                            {{-- Mobile: Data e Badge de Tipo --}}
                            <div class="col-12 col-md-2 d-flex justify-content-between align-items-center mb-3 mb-md-0">
                                <div>
                                    <span
                                        class="d-md-none badge {{ $mov->categoria->tipo == 'entrada' ? 'bg-success' : 'bg-danger' }} mb-2">
                                        {{ ucfirst($mov->categoria->tipo) }}
                                    </span>
                                    <div class="text-dark fw-bold">{{ $mov->data_vencimento->format('d/m/Y') }}</div>
                                    <small class="text-muted d-block">Pago em:
                                        {{ $mov->data_pagamento?->format('d/m/Y') ?? 'Pendente' }}</small>
                                </div>
                                <div class="btn-group shadow-sm d-md-none">
                                    <button class="btn btn-sm btn-outline-warning border-warning" title="Editar"
                                        data-bs-toggle="modal" data-bs-target="#modalEditar"
                                        onclick="fillEditMovimentacao('{{ $mov->id }}', '{{ $mov->categoria_id }}', '{{ $mov->pedido_id }}', '{{ $mov->descricao }}', '{{ $mov->valor }}', '{{ $mov->data_vencimento->format('Y-m-d') }}', '{{ $mov->data_pagamento ? $mov->data_pagamento->format('Y-m-d') : '' }}')"
                                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-danger" title="Excluir"
                                        onclick="deleteFinanceiro('{{ $mov->id }}')"
                                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <span class="d-block fw-bold text-dark">{{ $mov->descricao }}</span>
                                <span class="badge bg-light text-dark border small">{{ $mov->categoria->nome }}</span>
                            </div>

                            <div class="col-6 col-md-2 text-md-center">
                                <span class="d-md-none d-block text-muted small">Valor</span>
                                <span
                                    class="fw-bold {{ $mov->categoria->tipo == 'entrada' ? 'text-success' : 'text-danger' }}">
                                    {{ $mov->categoria->tipo == 'entrada' ? '+' : '-' }} R$
                                    {{ number_format($mov->valor, 2, ',', '.') }}
                                </span>
                            </div>

                            <div class="col-6 col-md-2 text-md-center">
                                @if ($mov->data_pagamento)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Efetuado</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pendente</span>
                                @endif
                            </div>

                            <div class="col-12 col-md-2 text-md-end d-none d-md-block">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-sm btn-outline-warning border-warning" title="Editar"
                                        data-bs-toggle="modal" data-bs-target="#modalEditar"
                                        onclick="fillEditMovimentacao('{{ $mov->id }}', '{{ $mov->categoria_id }}', '{{ $mov->pedido_id }}', '{{ $mov->descricao }}', '{{ $mov->valor }}', '{{ $mov->data_vencimento->format('Y-m-d') }}', '{{ $mov->data_pagamento ? $mov->data_pagamento->format('Y-m-d') : '' }}')"
                                        style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.15)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-danger" title="Excluir"
                                        onclick="deleteFinanceiro('{{ $mov->id }}')"
                                        style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.15)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal Nova Movimentação Financeira --}}
    <div class="modal fade" id="modalNovaMovimentacao" tabindex="-1" aria-labelledby="modalNovaMovimentacaoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalNovaMovimentacaoLabel">
                        Nova Movimentação
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'"
                        onmouseout="this.style.transform='scale(1)'"></button>
                </div>

                <form action="{{ route($bag['route'] . '.store', ['loja' => session('loja_slug')]) }}" method="POST"
                    id="formFinanceiro">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Categoria <span class="text-danger">*</span></label>
                                <select name="categoria_id" class="form-select shadow-sm" required>
                                    <option value="" selected disabled>Selecione uma categoria...</option>
                                    <optgroup label="Entradas">
                                        @foreach ($categorias->where('tipo', 'entrada') as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Saídas">
                                        @foreach ($categorias->where('tipo', 'saida') as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Pedido Relacionado (Opcional) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Vincular a um Pedido (Opcional)</label>
                                <select name="pedido_id" class="form-select shadow-sm border-dashed">
                                    <option value="">Registro Manual (Sem pedido)</option>
                                    @foreach ($pedidosRecentes as $pedido)
                                        <option value="{{ $pedido->id }}">Pedido #{{ $pedido->id }} -
                                            {{ $pedido->cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Descrição da Movimentação <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="descricao" class="form-control shadow-sm"
                                    placeholder="Ex: Pagamento Fornecedor X, Venda de Produto Y..." required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Valor (R$) <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-muted fw-bold">R$</span>
                                    <input type="number" step="0.01" name="valor"
                                        class="form-control fw-bold text-dark" placeholder="0,00" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-warning">Data de Vencimento <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="data_vencimento" class="form-control shadow-sm"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-success">Data de Pagamento (Se pago)</label>
                                <input type="date" name="data_pagamento" class="form-control shadow-sm">
                                <div class="form-text small">Deixe vazio se for uma conta a receber/pagar.</div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-4 py-3">
                        @include('utils.form.cancelsubmitbuttons', [
                            'cancel_route' => route($bag['route'] . '.index', [
                                'loja' => session('loja_slug'),
                            ]),
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Editar Movimentação Financeira --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Editar Movimentação
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditarMovimentacao" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Categoria</label>
                                <select name="categoria_id" id="edit_mov_categoria" class="form-select" required>
                                    <optgroup label="Entradas">
                                        @foreach ($categorias->where('tipo', 'entrada') as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Saídas">
                                        @foreach ($categorias->where('tipo', 'saida') as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Pedido Relacionado (Opcional) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Vínculo com Pedido (Opcional)</label>
                                <select name="pedido_id" id="edit_mov_pedido" class="form-select border-dashed">
                                    <option value="">Registro Manual</option>
                                    @foreach ($pedidosRecentes as $pedido)
                                        <option value="{{ $pedido->id }}">Pedido #{{ $pedido->id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small">Descrição</label>
                                <input type="text" name="descricao" id="edit_mov_descricao" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Valor (R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" step="0.01" name="valor" id="edit_mov_valor"
                                        class="form-control fw-bold" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-warning">Vencimento</label>
                                <input type="date" name="data_vencimento" id="edit_mov_vencimento"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-success">Data de Pagamento</label>
                                <input type="date" name="data_pagamento" id="edit_mov_pagamento"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-4 py-3">
                        @include('utils.form.cancelsubmitbuttons', [
                            'cancel_route' => route($bag['route'] . '.index', [
                                'loja' => session('loja_slug'),
                            ]),
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Categorias --}}
    <div class="modal fade" id="modalCategorias" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Gerenciar Categorias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'"
                        onmouseout="this.style.transform='scale(1)'"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-secondary btn-sm w-100 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalNovaCategoria" style="transition: transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="bi bi-plus-lg"></i> Criar Nova Categoria
                    </button>

                    <div class="list-group list-group-flush border rounded">
                        @foreach ($categorias as $cat)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">{{ $cat->nome }}</span>
                                    <small class="badge bg-light text-muted ms-2">{{ ucfirst($cat->tipo) }}</small>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-outline-warning border-warning" title="Editar"
                                        onclick="editCategoria('{{ $cat->id }}', '{{ $cat->nome }}', '{{ $cat->tipo }}')"
                                        style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.15)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger border-danger"
                                        onclick="deleteCategoria('{{ $cat->id }}')"
                                        style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.15)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal nova categoria aberta a partir do modal categorias --}}
    <div class="modal fade shadow-lg" id="modalNovaCategoria" tabindex="-1" aria-hidden="true"
        style="background: rgba(0,0,0,0.4);">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0">
                <form action="{{ route($bag['routeCategoria'] . '.store', session('loja_slug')) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-secondary text-white">
                        <h6 class="modal-title">Nova Categoria</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-toggle="modal"
                            data-bs-target="#modalCategorias" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.2)'"
                            onmouseout="this.style.transform='scale(1)'"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nome</label>
                            <input type="text" name="nome" class="form-control" required
                                placeholder="Ex: Aluguel">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Tipo</label>
                            <select name="tipo" class="form-select" required>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-2">
                        @include('utils.buttons.submit', [
                            'icon' => 'bi bi-check2-circle me-1',
                            'text' => 'Salvar Categoria',
                            'class' => 'btn btn-success btn-sm w-100',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal edit categoria aberta a partir do modal categorias --}}
    <div class="modal fade shadow-lg" id="modalEditCategoria" tabindex="-1" aria-hidden="true"
        style="background: rgba(0,0,0,0.4);">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0">
                <form id="formEditCategoria" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header bg-warning">
                        <h6 class="modal-title fw-bold">Editar Categoria</h6>
                        <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#modalCategorias" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.2)'"
                            onmouseout="this.style.transform='scale(1)'"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nome</label>
                            <input type="text" name="nome" id="edit_cat_nome" class="form-control" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Tipo</label>
                            <select name="tipo" id="edit_cat_tipo" class="form-select" required>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-2">
                        @include('utils.buttons.submit', [
                            'icon' => 'bi bi-check2-circle me-1',
                            'text' => 'Atualizar Categoria',
                            'class' => 'btn btn-success btn-sm w-100',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('utils.layout.pagination', ['items' => $movimentacoes])
@endsection

@push('scripts')
    <script>
        function fillEditMovimentacao(id, categoria_id, pedido_id, descricao, valor, vencimento, pagamento) {
            const form = document.getElementById('formEditarMovimentacao');
            form.action =
                "{{ route($bag['route'] . '.update', ['loja' => session('loja_slug'), 'financeiro' => '__ID__']) }}"
                .replace('__ID__', id);

            document.getElementById('edit_mov_categoria').value = categoria_id;
            document.getElementById('edit_mov_pedido').value = pedido_id || "";
            document.getElementById('edit_mov_descricao').value = descricao;
            document.getElementById('edit_mov_valor').value = valor;
            document.getElementById('edit_mov_vencimento').value = vencimento;
            document.getElementById('edit_mov_pagamento').value = pagamento;
        }

        function deleteFinanceiro(id) {
            if (confirm(
                    'Tem certeza que deseja excluir esta movimentação financeira?')) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action =
                    "{{ route($bag['route'] . '.destroy', ['loja' => session('loja_slug'), 'financeiro' => '__ID__']) }}"
                    .replace('__ID__', id);
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function editCategoria(id, nome, tipo) {
            const modalLista = bootstrap.Modal.getInstance(document.getElementById('modalCategorias'));
            modalLista.hide();

            const form = document.getElementById('formEditCategoria');
            form.action =
                "{{ route($bag['routeCategoria'] . '.update', ['loja' => session('loja_slug'), 'categoria' => '__ID__']) }}"
                .replace('__ID__', id);
            document.getElementById('edit_cat_nome').value = nome;
            document.getElementById('edit_cat_tipo').value = tipo;

            const modalEdit = new bootstrap.Modal(document.getElementById('modalEditCategoria'));
            modalEdit.show();
        }

        function deleteCategoria(id) {
            if (confirm(
                    'Tem certeza que deseja excluir esta categoria? Todas as movimentações vinculadas serão afetadas.')) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action =
                    "{{ route($bag['routeCategoria'] . '.destroy', ['loja' => session('loja_slug'), 'categoria' => '__ID__']) }}"
                    .replace('__ID__', id);
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
