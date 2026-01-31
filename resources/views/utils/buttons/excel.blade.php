@php
    $route = $route . '.excel';
    $class = $class ?? 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-success' : 'btn-success');
    $text = $text ?? 'Excel';
    $title = 'Baixar dados em Excel';
    $params = $_GET;
@endphp

@include('utils.buttons.link')
