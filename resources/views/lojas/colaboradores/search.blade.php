@extends('utils.search.index')

@section('search')
    <div class="form-group col-md-4">
        <label class="form-label small fw-bold text-muted">Nome do Colaborador</label>
        <input type="text" name="nome" class="form-control form-control-sm" value="{{ $_GET['nome'] ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label class="form-label small fw-bold text-muted">Cargos</label>
        <select class="form-select form-select-sm" name="cargo">
            <option disabled selected="">Selecione um cargo</option>
            @foreach ($cargos as $item)
                <option value="{{ $item->nome }}" {{ request()->query('cargo') === $item->nome ? 'selected' : '' }}>
                    {{ $item->nome }}
                </option>
            @endforeach
        </select>
    </div>
@stop
