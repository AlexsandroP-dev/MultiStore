@extends('utils.search.index')

@section('search')
    <div class="form-group col-md-4">
        <label class="form-label small fw-bold text-muted">Data Inicial</label>
        <input type="date" name="data_inicio" class="form-control form-control-sm" value="{{ $_GET['data_inicio'] ?? '' }}">
    </div>
    <div class="form-group col-md-4">
        <label class="form-label small fw-bold text-muted">Data Final</label>
        <input type="date" name="data_fim" class="form-control form-control-sm" value="{{ $_GET['data_fim'] ?? '' }}">
    </div>
    <div class="form-group col-md-2">
        <label class="form-label small fw-bold text-muted">Tipo</label>
        <select name="tipo" class="form-select form-select-sm">
            <option value="">Todos</option>
            <option value="entrada" {{ request()->query('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
            <option value="saida" {{ request()->query('tipo') == 'saida' ? 'selected' : '' }}>Saídas</option>
        </select>
    </div>
@stop
