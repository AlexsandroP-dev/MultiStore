@php
    $route = $route . '.download';
    $class = $class ?? 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-info' : 'btn-info');
@endphp

@include('utils.buttons.link', [
    'title' => 'Baixar',
    // 'icon' => 'fa fa-download',
])
