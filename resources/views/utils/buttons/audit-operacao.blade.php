@include('utils.buttons.link', [
    'title' => 'Ver Auditoria deste Registro',
    // 'route' => 'sistema.auditoria.operacoes',
    'class' => 'btn btn-sm ' . (session('layout_theme', 'light') === 'light' ? 'btn-outline-dark' : 'btn-dark'),
    // 'icon' => 'fa fa-calendar-check',
])
