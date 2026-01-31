@php
    $route = $route . '.restore';
    $params = $params ?? [];
    $id = $route . '_formRestore_' . implode('_', $params);
@endphp

@permiteroute($route, $onlyIf ?? true)
    <button class="btn btn-sm {{ session('layout_theme', 'light') === 'light' ? 'btn-outline-danger' : 'btn-danger' }}" type="button"
        title="Restaurar este Registro" onclick="document.getElementById('{{ $id }}').submit()">
        {{ $text ?? 'Restaurar' }}
    </button>
    <form id="{{ $id }}" method="POST" action="{{ route($route, $params) }}">
        @csrf
    </form>
@endpermiteroute
