@php
    $route = $route . '.show';
    $class = 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-info' : 'btn-info');
@endphp

@include('utils.buttons.link', [
    'title' => 'Ver este Registro',
    // 'icon' => 'fa fa-search',
])
