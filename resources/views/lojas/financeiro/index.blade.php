@extends('layouts.lojas.page')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50 d-block">Saldo (Mês)</small>
                            <h4 class="mb-0">R$ 15.250,00</h4>
                        </div>
                        <i class="bi bi-wallet2 fs-2 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block">Entradas (Mês)</small>
                    <h4 class="mb-0 text-success">+ R$ 8.400,00</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block">Saídas (Mês)</small>
                    <h4 class="mb-0 text-danger">- R$ 3.120,00</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block">A Pagar (Hoje)</small>
                    <h4 class="mb-0 text-warning">R$ 450,00</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Movimentações</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaMovimentacao"
                style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.06)'"
                onmouseout="this.style.transform='scale(1)'">
                <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Nova Movimentação</span>
            </button>
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
                            <div class="col-12 col-md-2">
                                <span
                                    class="d-md-none badge {{ $mov->categoria->tipo == 'entrada' ? 'bg-success' : 'bg-danger' }} mb-2">
                                    {{ ucfirst($mov->categoria->tipo) }}
                                </span>
                                <div class="text-dark fw-bold">{{ $mov->data_vencimento->format('d/m/Y') }}</div>
                                <small class="text-muted d-block">Pago em:
                                    {{ $mov->data_pagamento?->format('d/m/Y') ?? 'Pendente' }}</small>
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

                            <div class="col-12 col-md-2 text-md-end">
                                <div class="btn-group shadow-sm">
                                    <button class="btn btn-sm btn-outline-light border text-dark" title="Editar"
                                        data-bs-toggle="modal" data-bs-target="#modalEditar{{ $mov->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Excluir"
                                        onclick="confirmDelete('{{ $mov->id }}')">
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

                            {{-- Seleção de Categoria --}}
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

                            {{-- Descrição --}}
                            <div class="col-12">
                                <label class="form-label fw-bold">Descrição da Movimentação <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="descricao" class="form-control shadow-sm"
                                    placeholder="Ex: Pagamento Fornecedor X, Venda de Produto Y..." required>
                            </div>

                            {{-- Valor --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Valor (R$) <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-muted fw-bold">R$</span>
                                    <input type="number" step="0.01" name="valor"
                                        class="form-control fw-bold text-dark" placeholder="0,00" required>
                                </div>
                            </div>

                            {{-- Data Vencimento --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-warning">Data de Vencimento <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="data_vencimento" class="form-control shadow-sm"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- Data Pagamento (Opcional) --}}
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
    @include('utils.layout.pagination', ['items' => $movimentacoes])
@endsection
