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
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Cadastrado em</th>
                        <th>Válido até</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($lojas as $item)
                            <tr>
                                <td>{{ $item->id }} </td>
                                <td>{{ $item->nome }} </td>
                                <td>{{ $item->created_at->format('d-m-Y') }} </td>
                                <td>{{ $item->expira_em }} </td>
                                <td class="d-flex gap-2 justify-content-center" style="">
                                    @include('utils.buttons.show', [
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
