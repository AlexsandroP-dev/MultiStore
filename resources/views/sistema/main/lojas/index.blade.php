@extends('layouts.page')

@section('content')
    @include('utils.layout.indexHeader', [
        'enableHeaderButtons' => true,
        'session' => 'lojas_visualizacao',
        'route' => $bag['route'],
        'params' => [],
    ])
    @if (session('lojas_visualizacao', 'grid') == 'grid')
        <div class="row g-3">
            @foreach ($lojas as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($item->diretorio_logo)
                            <img src="{{ asset('storage/' . $item->diretorio_logo) }}" alt="{{ $item->nome }}"
                                class="img-thumbnail rounded shadow-sm d-block mx-auto"
                                style="width: 180px; height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-shop text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item->nome }}</h5>
                            <p class="card-text text-muted mb-2" style="font-size: 0.875rem;">ID:
                                #{{ $item->id }}</p>
                            <p class="card-text text-muted mb-2" style="font-size: 0.875rem;">Cadastrado em:
                                {{ $item->created_at->format('d/m/Y') }}
                            @if ($item->isActive())
                                <p class="card-text text-muted mb-2" style="font-size: 0.900rem;">Válido até: <span
                                        class="badge bg-success-subtle text-success border border-success-subtle mt-1"
                                        style="width: fit-content;">
                                        {{ $item->expira_em->format('d/m/Y') }}
                                    </span></p>
                            @else
                                <p class="card-text text-muted mb-2" style="font-size: 0.900rem;">Expirou em: <span
                                        class="badge bg-danger-subtle text-danger border border-danger-subtle mt-1"
                                        style="width: fit-content;">
                                        {{ $item->expira_em->format('d/m/Y') }}
                                    </span></p>
                            @endif
                            <div class="mt-auto">
                                @include('utils.buttons.show', [
                                    'route' => $bag['route'],
                                    'params' => [
                                        'loja' => $item->id,
                                    ],
                                ])
                                @include('utils.buttons.edit', [
                                    'route' => $bag['route'],
                                    'params' => [
                                        'loja' => $item->id,
                                    ],
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-wrap mb-0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Logo</th>
                                <th>Nome</th>
                                <th>Cadastrado em</th>
                                <th>Válido até</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lojas as $item)
                                <tr>
                                    <td class="text-muted small">{{ $item->id }}</td>
                                    <td>
                                        @if ($item->diretorio_logo)
                                            <img src="{{ asset('storage/' . $item->diretorio_logo) }}"
                                                alt="{{ $item->nome }}" class="img-thumbnail rounded shadow-sm"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <i class="bi bi-shop fs-1 justify-content-center"></i>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $item->nome }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $item->expira_em->format('d/m/Y') }}</span>
                                            @if ($item->isActive())
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle mt-1"
                                                    style="width: fit-content;">
                                                    Ativo
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle mt-1"
                                                    style="width: fit-content;">
                                                    Expirado
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @include('utils.buttons.show', [
                                            'route' => $bag['route'],
                                            'params' => ['loja' => $item->id],
                                        ])
                                        @include('utils.buttons.edit', [
                                            'route' => $bag['route'],
                                            'params' => ['loja' => $item->id],
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @include('utils.layout.pagination', ['items' => $lojas])
@endsection
