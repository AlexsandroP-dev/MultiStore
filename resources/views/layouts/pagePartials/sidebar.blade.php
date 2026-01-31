<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark transition-all"
    style="width: 280px; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
        <a class="text-white text-decoration-none" href="{{ route(config('themes.mainTheme.sidebar.sideBarHeaderRoute')) }}"><span
                class="fs-4 logo-text fw-bold">{{ config('themes.mainTheme.sidebar.sideBarHeaderName') }}</span></a>

        <button class="btn text-white border-0 p-0" id="mobileSideBarToggle">
            <i class="bi bi-x-lg fs-3 d-inline d-md-none"></i>
        </button>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        @foreach (config('themes.mainTheme.sidebar.sideBarItems') as $item)
            @if (isset($item['submenu']))
                {{-- Item com Dropdown --}}
                <li class="nav-item">
                    @php
                        $subRoutes = collect($item['submenu'])->pluck('route')->toArray();
                        $isOpen = false;
                        foreach ($subRoutes as $sr) {
                            if (request()->routeIs($sr)) {
                                $isOpen = true;
                                break;
                            }
                        }
                    @endphp

                    <a class="nav-link py-3 d-flex align-items-center justify-content-between {{ $isOpen ? 'bg-primary text-white' : 'text-white' }}"
                        data-bs-toggle="collapse" href="#submenu{{ Str::slug($item['name']) }}" role="button"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                        <div>
                            <i class="{{ $item['icon'] }} me-2"></i>
                            <span class="nav-text">{{ $item['name'] }}</span>
                        </div>
                        <i class="bi bi-chevron-down small nav-text arrow-icon {{ $isOpen ? 'rotate-180' : '' }}"></i>
                    </a>

                    <div class="collapse {{ $isOpen ? 'show' : '' }}" id="submenu{{ Str::slug($item['name']) }}">
                        <ul class="nav flex-column ms-3 mt-1 small border-start border-secondary border-opacity-25">
                            @foreach ($item['submenu'] as $sub)
                                <li class="nav-item">
                                    <a href="{{ route($sub['route']) }}"
                                        class="nav-link py-2 {{ request()->routeIs($sub['route']) ? 'text-primary fw-bold active-sub' : 'text-white-50' }}">
                                        <i class="{{ $sub['icon'] ?? 'bi bi-circle' }} me-2"
                                            style="font-size: 0.7rem;"></i>
                                        {{ $sub['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @else
                {{-- Item Simples --}}
                <li class="nav-item">
                    <a href="{{ route($item['route']) }}"
                        class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }} py-3"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $item['name'] }}">
                        <i class="{{ $item['icon'] }} me-2"></i>
                        <span class="nav-text">{{ $item['name'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>

@push('css')
    <style>
        .transition-all {
            transition: all 0.3s ease-in-out;
        }

        /* Largura padrão desktop */
        #sidebar {
            width: 280px;
            z-index: 1050;
        }

        /* Comportamento Mobile (abaixo de 768px) */
        @media (max-width: 767.98px) {
            #sidebar {
                margin-left: -280px;
                position: fixed;
                height: 100vh;
                /* box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2); */
            }

            #sidebar.show-mobile {
                margin-left: 0;
            }

            /* Overlay para escurecer o fundo quando a sidebar abrir no mobile */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                /* Configuração inicial para animação */
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }

        .sidebar-collapsed {
            width: 80px !important;
        }

        .sidebar-collapsed .logo-text,
        .sidebar-collapsed .nav-text {
            display: none;
        }

        /* Estilo para todos os items da sidebar exceto o ativo */
        #sidebar .nav-link {
            transition: all 0.2s ease-in-out;
            border-radius: 8px;
            margin: 2px 0;
            color: rgba(255, 255, 255, 0.8);
            /* Cor levemente opaca para o estado normal */
        }

        /* Hover com destaque real */
        #sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            transform: translateX(5px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Ajuste no item Ativo para não sofrer o deslocamento do hover */
        #sidebar .nav-link.active {
            background-color: var(--bs-primary) !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        #sidebar .nav-link.active:hover {
            transform: none;
            /* Mantém o item ativo parado */
        }

        /* Ajuste de indentação do submenu */
        #sidebar .collapse .nav-link {
            padding-left: 1.5rem;
        }

        /* Esconde a setinha quando a sidebar estiver colapsada */
        .sidebar-collapsed .bi-chevron-down {
            display: none;
        }

        /* Cor dos itens dentro do dropdown */
        .nav-pills .nav-link.text-white-50:hover {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* Esconde submenus quando a sidebar está colapsada */
        .sidebar-collapsed .collapse,
        .sidebar-collapsed .collapse.show {
            display: none !important;
        }

        /* Estilo para destacar o subitem ativo de forma diferente do item principal */
        #sidebar .nav-link.active-sub {
            background-color: rgba(13, 110, 253, 0.1) !important;
            /* Fundo azul bem suave */
            color: #0d6efd !important;
            /* Cor primária do Bootstrap */
        }

        /* Classe auxiliar para o carregamento inicial via Blade */
        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Linha lateral para dar continuidade visual ao submenu */
        #sidebar .collapse ul {
            margin-left: 1.2rem !important;
            padding-left: 0.5rem;
        }

        /* Garante que o item pai ativo no modo colapsado não tenha texto ou seta */
        .sidebar-collapsed .nav-text {
            display: none !important;
        }

        /* Configuração base da seta do dropdown */
        .arrow-icon {
            transition: transform 0.3s ease-in-out;
        }

        /* Quando o botão dropdown NÃO está colapsado (ou seja, está aberto), giramos a seta */
        .nav-link[aria-expanded="true"] .arrow-icon {
            transform: rotate(180deg);
        }

        /* Ocultar seta no modo colapsado para não quebrar o layout de 80px */
        .sidebar-collapsed .arrow-icon {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            // Seleciona o botão da sidebar e também o da TopNav (se houver)
            const togglers = document.querySelectorAll('#sidebarToggle, #mobileSideBarToggle');

            // Criar overlay dinamicamente se não existir
            let overlay = document.querySelector('.sidebar-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'sidebar-overlay';
                document.body.appendChild(overlay);
            }

            const toggleMenu = () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.toggle('show-mobile');
                    overlay.classList.toggle('active');
                } else {
                    sidebar.classList.toggle('sidebar-collapsed');
                }
            };

            togglers.forEach(btn => btn.addEventListener('click', toggleMenu));
            overlay.addEventListener('click', toggleMenu); // Fechar ao clicar fora
        });
    </script>
@endpush
