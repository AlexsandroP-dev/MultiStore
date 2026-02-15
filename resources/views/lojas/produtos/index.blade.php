@extends('layouts.lojas.page')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="btn-list">
            @include('utils.buttons.create', [
                'route' => $bag['route'],
                'params' => ['loja' => session('loja_slug')],
            ])
            {{-- @include('utils.buttons.link', [
            'route' => $bag['route']. '.deleted',
            'class' => 'btn btn-sm btn-outline-danger',
            'text' => 'Registros Apagados',
        ]) --}}
        </div>
        <div class="btn-group shadow-sm" role="group" aria-label="Visualização">
            <a href="{{ route($bag['route'] . '.set.visualizacao', ['loja' => session('loja_slug'), 'modo' => 'tabela']) }}"
                class="btn btn-sm btn-outline-primary me-2 {{ session('loja_produto_visualizacao', 'tabela') == 'tabela' ? 'active' : '' }}"
                title="Visualizar como Tabela" style="transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i
                    class="bi bi-table"></i></a>
            <a href="{{ route($bag['route'] . '.set.visualizacao', ['loja' => session('loja_slug'), 'modo' => 'grid']) }}"
                class="btn btn-sm btn-outline-primary {{ session('loja_produto_visualizacao') == 'grid' ? 'active' : '' }}"
                title="Visualizar como Grade" style="transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i
                    class="bi bi-grid"></i></a>
        </div>
    </div>
    @if (session('loja_produto_visualizacao', 'tabela') == 'tabela')
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
    @else
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
    @endif
    @include('utils.layout.pagination', ['items' => $produtos])
@endsection
