@php
    $type = isset($type) && $type === 'card' ? 'card' : 'modal';
@endphp

@extends('utils.search.' . $type)

@section('form')
    <div class="row">
        @yield('search')
    </div>
    @if (isset($between))
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="form-label" for="created_from">Cadastrado a partir do dia:</label>
                <input type="date" name="created_from" id="created_from" value="{{ $_GET['created_from'] ?? '' }}"
                    class="form-control">
            </div>
            <div class="form-group col-lg-6">
                <label class="form-label" for="created_to">Cadastrado até o dia:</label>
                <input type="date" name="created_to" id="created_to" value="{{ $_GET['created_to'] ?? '' }}"
                    class="form-control">
            </div>
        </div>
    @endif
@stop

@section('buttons')
    <div class="form-group col-lg-3">
        <div class="input-group">
            <div class="input-group-text">
                <span>QTD</span>
            </div>
            <input type="number" name="qtd" id="qtd" value="{{ $_GET['qtd'] ?? 15 }}"
                class="form-control form-control-sm" step="1" minlength="1" maxlength="100">
        </div>
    </div>
    <div class="btn-list">
        <a href="{{ request()->url() }}" class="btn btn-sm btn-outline-dark" style="transition: transform 0.2s;"
            onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">Redefinir</a>
        @include('utils.buttons.submit', ['text' => 'Pesquisar', 'csrf' => false])
    </div>
@stop
