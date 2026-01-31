<div class="card">
    <div class="card-header border-bottom-0 pb-2">
        <h5>Filtrar</h5>
    </div>
    <form method="GET" action="{{ request()->url() }}">
        <div class="card-body py-0">
            @yield('form')
        </div>
        <div class="card-footer border-top-0 pt-0 d-flex align-items-center justify-content-between">
            @yield('buttons')
        </div>
    </form>
</div>
