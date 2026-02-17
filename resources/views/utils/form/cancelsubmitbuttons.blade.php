<hr class="my-4 text-muted">
<div class="d-flex justify-content-end gap-2">
    @include('utils.buttons.cancel', [
        'route' => $cancel_route,
    ])
    @include('utils.buttons.submit', [
        'icon' => 'bi bi-check2-circle me-1',
    ])
</div>
