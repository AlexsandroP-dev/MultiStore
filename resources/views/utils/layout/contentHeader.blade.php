<div class="row">
    <div class="col-lg-6 col-12">
        <h3 class="mb-0">{{ $title }}</h3>
        @if (isset($subtitle))
            <p>{{ $subtitle }}</p>
        @endif
    </div>
    <div class="col-lg-6 col-12">
        <ol class="breadcrumb justify-content-end">
            @foreach ($items as $key => $route)
                @php
                    $route_name = $route[0] ?? null;
                    $params = $route[1] ?? [];
                    $rules = $route[2] ?? true;
                @endphp
                @if ($route == null)
                    <li class="breadcrumb-item active">
                        {{ $key }}
                    </li>
                @else
                    @permiteroute($route_name, $rules)
                        <li class="breadcrumb-item">
                            <a href="{{ route($route_name, $params) }}">
                                {{ $key }}
                            </a>
                        </li>
                    @endpermiteroute
                @endif
            @endforeach
        </ol>
    </div>
</div>

{{--
    Preencher os itens dessa forma
    Items => [
        'texto' => ['route_name', ['params'], 'condicao_extra'],
        ...,
        'texto' => null (esta é a pagina que atual)
    ]
--}}
