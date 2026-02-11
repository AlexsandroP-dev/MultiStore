@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>
                <strong class="d-block">Ops! Algo deu errado:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
            style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'"
            onmouseout="this.style.transform='scale(1)'"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
            style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'"
            onmouseout="this.style.transform='scale(1)'"></button>
    </div>
@endif
