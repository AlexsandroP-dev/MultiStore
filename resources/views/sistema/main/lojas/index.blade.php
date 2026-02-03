@extends('layouts.page')

@section('content')
    <div class="btn-list mb-3">
        @include('utils.buttons.create', ['route' => $bag['route']])
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
                            <th>Id</th>
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
    @include('utils.layout.pagination', ['items' => $lojas])
@endsection
