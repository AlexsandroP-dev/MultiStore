<div class="d-flex justify-content-between align-items-center mb-3">
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
        <div class="btn-group shadow-sm" role="group" aria-label="Visualização">
            <a href="{{ route($route . '.set.visualizacao', array_merge($params, ['modo' => 'tabela'])) }}"
                class="btn btn-sm btn-outline-primary me-2 {{ session('loja_produto_visualizacao', 'tabela') == 'tabela' ? 'active' : '' }}"
                title="Visualizar como Tabela" style="transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i
                    class="bi bi-table"></i></a>
            <a href="{{ route($route . '.set.visualizacao', array_merge($params, ['modo' => 'grid'])) }}"
                class="btn btn-sm btn-outline-primary {{ session('loja_produto_visualizacao') == 'grid' ? 'active' : '' }}"
                title="Visualizar como Grade" style="transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i
                    class="bi bi-grid"></i></a>
        </div>
    </div>