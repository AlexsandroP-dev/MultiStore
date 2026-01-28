@php
    $route = $route . '.permission.edit';
    $class = 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-warning' : 'btn-warning');
@endphp

@include('utils.buttons.link', [
    'title' => 'Editar Perfis e Permissões',
    // 'icon' => 'fa fa-eye',
])
