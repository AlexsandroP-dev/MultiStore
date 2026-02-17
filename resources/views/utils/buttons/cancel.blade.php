@php
    $class = $class ?? 'btn btn-light border';
@endphp

<a href="{{ $route }}" class="{{ $class }}" id="{{ $id ?? '' }}" title="Cancelar"
    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'"
    onmouseout="this.style.transform='scale(1)'">
    @if (isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    {{ $text ?? 'Cancelar' }}
</a>
