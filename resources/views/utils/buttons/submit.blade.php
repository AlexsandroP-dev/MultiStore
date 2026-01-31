@php
    $class = $class ?? 'btn btn-sm btn-success';
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
                            ">
    @if (isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    {{ $text ?? 'Salvar' }}
</button>
