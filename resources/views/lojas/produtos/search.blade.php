@extends('utils.search.index')

@section('search')
    <div class="form-group col-md-4">
        <label class="form-label small fw-bold text-muted">Nome do Produto</label>
        <input type="text" name="nome" class="form-control form-control-sm" value="{{ $_GET['nome'] ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label class="form-label small fw-bold text-muted">Categorias dos Produtos</label>
        <select class="form-select form-select-sm" name="categoria">
            <option disabled selected="">Selecione uma categoria</option>
            @foreach ($categorias as $item)
                <option value="{{ $item->nome }}" {{ request()->query('categoria') === $item->nome ? 'selected' : '' }}>
                    {{ $item->nome }}
                </option>
            @endforeach
        </select>
    </div>
@stop
