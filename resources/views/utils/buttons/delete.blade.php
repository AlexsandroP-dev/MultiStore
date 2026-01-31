@php
    $route = $route . '.destroy';
    $params = $params ?? [];
    $id = $route . '_formDelele_' . implode('_', $params);
@endphp

@if (Route::has($route))
    @permiteroute($route, $onlyIf ?? true)
        <button class="btn btn-sm {{ session('layout_theme', 'light') === 'light' ? 'btn-outline-danger' : 'btn-danger' }}"
            type="button" title="Apagar este Registro" onclick="document.getElementById('{{ $id }}').submit()">
            {{-- <i class="fa fa-trash"></i> --}}
            {{ $text ?? '' }}
        </button>
        <form id="{{ $id }}" method="POST" action="{{ route($route, $params) }}">
            @csrf
        </form>
    @endpermiteroute
@endif
