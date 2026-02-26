<button class="btn btn-dark btn-sm" id="modal-button-search" data-bs-toggle="modal" data-bs-target="#modal-search"
    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'"
    onmouseout="this.style.transform='scale(1)'">
    <i class="bi bi-search"></i> <span class="d-none d-md-inline">Filtrar</span>
</button>

<div class="modal fade" id="modal-search" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Filtrar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'"
                    onmouseout="this.style.transform='scale(1)'"></button>
            </div>
            <form method="GET" action="{{ request()->url() }}">
                <div class="modal-body">
                    @yield('form')
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between">
                    @yield('buttons')
                </div>
            </form>
        </div>
    </div>
</div>
