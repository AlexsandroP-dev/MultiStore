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
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaMovimentacao">
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
    @include('utils.layout.pagination', ['items' => $movimentacoes])
@endsection
