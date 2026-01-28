@php
    $params = $params ?? [$param ?? $route => $model->getKey()];
@endphp

@include('utils.buttons.password')
@include('utils.buttons.permission')
@include('utils.buttons.audit-acesso', [
    'params' => ['user_id' => $model->getKey()],
])
@include('utils.buttons.model')
