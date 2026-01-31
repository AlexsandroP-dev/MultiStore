@php
    $params = $params ?? [];
    $id = $route . '_' . implode('_', $params);
@endphp

@permiteroute($route, $onlyIf ?? true)
    <a href="{{ route($route, $params) }}" title="{{ $title ?? '' }}" id="{{ $id }}" class="{{ $class ?? '' }}">
        @if (isset($icon))
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text ?? '' }}
    </a>
@endpermiteroute
