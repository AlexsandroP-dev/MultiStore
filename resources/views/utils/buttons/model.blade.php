@php
    $params = $params ?? [$param ?? $route => $model->getKey()];
@endphp

@include('utils.buttons.audit-operacao', [
    'params' => ['table_name' => $model->getTable(), 'table_id' => $model->getKey()],
])
@include('utils.buttons.edit', ['onlyIf' => $editIf ?? ($onlyIf ?? true)])
@include('utils.buttons.delete', ['onlyIf' => $deleteIf ?? ($onlyIf ?? true)])
