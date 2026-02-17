@php
    $class = $class ?? 'btn btn-success px-4';
    $csrf = $csrf ?? true;
@endphp

@if ($csrf)
    @csrf
@endif

<button class="{{ $class }}" id="{{ $id ?? '' }}" type="submit" title="Salvar este Registro"
    onclick="
                                var e=this;
                                setTimeout(function(){e.disabled=true;},0);
                                setTimeout(function(){e.disabled=false;},10000);
                                return true;
                            "
    style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'"
    onmouseout="this.style.transform='scale(1)'">
    @if (isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    {{ $text ?? 'Salvar' }}
</button>
