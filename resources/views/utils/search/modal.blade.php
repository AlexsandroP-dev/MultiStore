<button class="btn btn-sm btn-outline-secondary" id="modal-button-search" data-bs-toggle="modal"
    data-bs-target="#modal-search">
    Filtrar
</button>

<div class="modal fade" id="modal-search" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Filtrar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
