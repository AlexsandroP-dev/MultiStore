@php
    $links = $items instanceof \Illuminate\Pagination\LengthAwarePaginator ? $items->appends($_GET) : null;
@endphp
@if ($items->count() != 0)
    <div class="row mt-3">
        <div class="{{ $links ? 'col-lg-5 col-md-5' : 'col-lg-12' }}">
            @if ($links)
                Exibindo itens de {{ $items->firstItem() }} a {{ $items->lastItem() }} de {{ $items->total() }}
                encontrados.
            @else
                {{ $items->count() }} itens na lista.
            @endif
        </div>
        @if ($links)
            <div class="col-lg-7 col-md-7">
                {{ $links->links() }}
            </div>
        @endif
    </div>
@else
    <div class="alert alert-outline-dark mt-3" role="alert">
        <b>Nenhum dado encontrado.</b>
    </div>
@endif
