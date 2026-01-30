<nav class="navbar navbar-expand navbar-light bg-white border-bottom p-3">
    <div class="container-fluid">
        <ul class="navbar-nav me-auto">
            <button class="btn border-0 p-0" id="sidebarToggle" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Sidebar">
                <i class="bi bi-list fs-3"></i>
            </button>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Menu
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Ação 1</a></li>
                    <li><a class="dropdown-item" href="#">Ação 2</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre nós</a>
            </li>
        </ul>

        <div class="d-flex align-items-center">
            @auth
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center shadow-sm" type="button"
                        id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5 {{ Auth::check() ? 'me-sm-2' : '' }}"></i>
                        <span class="d-none d-sm-inline">
                            {{ Auth::user()->name }}
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> Meu Perfil
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            @endauth
        </div>
    </div>
</nav>

@push('css')
    <style>
        /* Estilo para os links da TopNav */
        .navbar-nav .nav-link {
            padding: 8px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            color: #555;
        }

        /* Hover na TopNav */
        .navbar-nav .nav-link:hover {
            background-color: #f8f9fa;
            /* Cinza bem clarinho */
            color: var(--bs-primary);
            /* Texto muda para a cor principal */
        }

        /* Botão de Login com hover mais forte */
        .btn-outline-primary:hover {
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
            transform: translateY(-1px);
        }

        /* Dropdown do usuário */
        .dropdown-toggle:hover {
            background-color: #ececec !important;
        }

        /* Estilo para os items do dropdown */
        .dropdown-item {
            transition: all 0.3s ease;
        }

        /* Hover nos items do dropdown */
        .dropdown-item:hover {
            background-color: #ececec;
            color: var(--bs-primary);
        }
    </style>
@endpush
