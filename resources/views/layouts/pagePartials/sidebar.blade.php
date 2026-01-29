<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark transition-all"
    style="width: 280px; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
        <span class="fs-4 logo-text fw-bold">['nada aqui']</span>
        <button class="btn text-white border-0 p-0" id="sidebarToggle" data-bs-toggle="tooltip" data-bs-placement="right"
            title="Sidebar">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link active py-3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Dashboard">
                <i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link py-3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Dashboard">
                <i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">['nada aqui']</span>
            </a>
        </li>
    </ul>
</div>

@push('css')
    <style>
        .transition-all {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 80px !important;
        }

        .sidebar-collapsed .logo-text,
        .sidebar-collapsed .nav-text {
            display: none;
        }

        .sidebar-collapsed .nav-link {
            text-align: center;
        }

        .sidebar-collapsed .d-flex.justify-content-between {
            justify-content: center !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const btn = document.getElementById('sidebarToggle');

            // Inicializa os tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

            const updateTooltips = () => {
                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                tooltipList.forEach(t => isCollapsed ? t.enable() : t.disable());
            };

            updateTooltips(); // Estado inicial

            btn.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-collapsed');
                updateTooltips();
                tooltipList.forEach(t => t.hide());
            });
        });
    </script>
@endpush
