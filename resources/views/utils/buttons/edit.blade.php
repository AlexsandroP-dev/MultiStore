@php
    $route = $route . '.edit';
    $class = 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-warning' : 'btn-warning');
@endphp

@if (Route::has($route))
    @include('utils.buttons.link', [
        'title' => 'Editar este Registro',
        // 'icon' => 'fa fa-edit',
    ])
@endif
