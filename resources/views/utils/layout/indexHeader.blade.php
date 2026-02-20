<div class="d-flex justify-content-between align-items-center mb-3">
    @if ($enableHeaderButtons == true)
        <div class="btn-list">
            @include('utils.buttons.create', [
                'route' => $route,
                'params' => $params,
            ])
            {{-- @include('utils.buttons.link', [
            'route' => $route. '.deleted',
            'class' => 'btn btn-sm btn-outline-danger',
            'text' => 'Registros Apagados',
        ]) --}}
        </div>
    @endif
    <div class="btn-group shadow-sm ms-auto gap-2" role="group" aria-label="Visualização">
        <a href="{{ route($route . '.set.visualizacao', array_merge($params, ['modo' => 'grid'])) }}"
            class="btn btn-sm btn-outline-primary {{ session($session, 'grid') == 'grid' ? 'active' : '' }}"
            title="Visualizar como Grade" style="transition: transform 0.2s;"
            onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i
                class="bi bi-grid"></i></a>
        <a href="{{ route($route . '.set.visualizacao', array_merge($params, ['modo' => 'tabela'])) }}"
            class="btn btn-sm btn-outline-primary {{ session($session) == 'tabela' ? 'active' : '' }}"
            title="Visualizar como Tabela" style="transition: transform 0.2s;"
            onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i
                class="bi bi-table"></i></a>
    </div>
</div>
