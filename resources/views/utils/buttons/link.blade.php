@php
    $params = $params ?? [];
    $id = $route . '_' . implode('_', $params);
@endphp

@permiteroute($route, $onlyIf ?? true)
    <a href="{{ route($route, $params) }}" title="{{ $title ?? '' }}" id="{{ $id }}" class="{{ $class ?? '' }}"
        style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'"
        onmouseout="this.style.transform='scale(1)'">
        @if (isset($icon))
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text ?? '' }}
    </a>
@endpermiteroute
