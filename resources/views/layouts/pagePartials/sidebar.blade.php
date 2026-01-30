<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark transition-all"
    style="width: 280px; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
        <span class="fs-4 logo-text fw-bold">['nada aqui']</span>

        <button class="btn text-white border-0 p-0" id="mobileSideBarToggle">
            <i class="bi bi-x-lg fs-3 d-inline d-md-none"></i>
        </button>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} py-3"
                data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }} py-3"
                data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">['nada aqui']</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-3 text-white d-flex align-items-center justify-content-between"
                data-bs-toggle="collapse" href="#submenuCadastros" role="button" aria-expanded="false">
                <div>
                    <i class="bi bi-grid me-2"></i>
                    <span class="nav-text">Cadastros</span>
                </div>
                <i class="bi bi-chevron-down small nav-text"></i>
            </a>
            <div class="collapse {{ request()->routeIs('login.*', 'logout.*') ? 'show' : '' }}" id="submenuCadastros">
                <ul class="nav flex-column ms-3 mt-1 small">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white-50 py-2">
                            <i class="bi bi-box me-2"></i> Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white-50 py-2">
                            <i class="bi bi-tags me-2"></i> Categorias
                        </a>
                    </li>
                </ul>
            </div>
        </li>
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
