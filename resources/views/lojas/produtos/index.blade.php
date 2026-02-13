@extends('layouts.lojas.page')

@section('content')
    <div class="btn-list mb-3">
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
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="bi bi-image fs-1 d-block mb-2"></i>
                                            <span>Sem imagem disponível</span>
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
    @include('utils.layout.pagination', ['items' => $produtos])
@endsection
