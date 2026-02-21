@extends('layouts.lojas.page')

@section('content')
    @include('utils.layout.indexHeader', [
        'enableHeaderButtons' => true,
        'session' => 'loja_produto_visualizacao',
        'route' => $bag['route'],
        'params' => ['loja' => session('loja_slug')],
    ])
    @if (session('loja_produto_visualizacao', 'grid') == 'grid')
        <div class="row g-3">
            @foreach ($produtos as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($item->diretorio_imagem)
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
                            <p class="card-text text-muted mb-0" style="font-size: 0.875rem;">Estoques:
                                @if ($item->estoque)
                                    @if ($item->estoque->quantidade > $item->estoque->estoque_minimo)
                                        <span class="badge bg-success-subtle text-success p-2 px-2 rounded-pill">
                                            {{ $item->estoque->quantidade }}
                                            {{ $item->estoque->medida }}</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger p-2 px-2 rounded-pill">
                                            {{ $item->estoque->quantidade }}
                                            {{ $item->estoque->medida }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">Sem estoques cadastrados</span>
                                @endif
                            </p>
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
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Cadastrado em</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $item)
                                <tr>
                                    <td>
                                        @if ($item->diretorio_imagem)
                                            <img src="{{ asset('storage/' . $item->diretorio_imagem) }}"
                                                alt="{{ $item->nome }}" class="img-thumbnail rounded shadow-sm"
                                                style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded border"
                                                style="width: 70px; height: 70px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="ps-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark">{{ $item->nome }}</span>
                                            <small class="text-muted" style="font-size: 0.75rem;">Categoria:
                                                #{{ $item->categoria->nome }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @include('utils.layout.pagination', ['items' => $produtos])
@endsection
