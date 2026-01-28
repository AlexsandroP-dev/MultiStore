@php
    $route = $route . '.password.edit';
    $class = 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-warning' : 'btn-warning');
@endphp

@include('utils.buttons.link', [
    'title' => 'Editar Senha',
    // 'icon' => 'fa fa-lock-open',
])
