@if (session()->has('alert'))
    @php
        $alert = session()->get('alert');
    @endphp
    <div role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000"
        class="bs-toast toast toast-placement-ex m-2 {{ $alert['type'] }} top-0 end-0">
        <div class="toast-header">
            <i class='fa fa-bell me-2'></i>
            <div class="me-auto fw-semibold">{{ $alert['title'] }}</div>
            <small>{{ now() }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $alert['message'] }}
        </div>
    </div>
    <script type="text/javascript">
        new bootstrap.Toast(document.querySelector('.toast-placement-ex')).show();
    </script>
@endif
