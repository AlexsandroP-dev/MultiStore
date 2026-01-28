@include('utils.buttons.link', [
    'title' => 'Ver Acessos',
    // 'route' => 'sistema.auditoria.acessos',
    'class' => 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-dark' : 'btn-dark'),
    // 'icon' => 'fa fa-door-open',
])
