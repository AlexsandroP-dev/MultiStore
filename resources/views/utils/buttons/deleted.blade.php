@php
    $route = $route . '.deleted';
    $class = 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-secondary' : 'btn-secondary');
@endphp

@include('utils.buttons.link', [
    'text' => $text ?? 'Apagados',
    'title' => 'Ver Lista de Apagados',
])
