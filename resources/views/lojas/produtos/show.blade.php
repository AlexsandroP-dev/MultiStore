@extends('layouts.lojas.page')

@section('content')
    <div class="container-fluid py-4">
        @include('utils.layout.alertsCustom')

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-end mb-4">
                    <div class="d-flex gap-2">
                        <a href="{{ route($bag['route'] . '.edit', ['loja' => session('loja_slug'), 'categoria' => $produto->categoria->slug, 'produto' => $produto->slug]) }}"
                            class="btn btn-sm btn-outline-primary" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-pencil me-1"></i> Editar
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4 border-end"
                                style="min-height: 400px;">
                                @if ($produto->diretorio_imagem)
                                    <img src="{{ asset('storage/' . $produto->diretorio_imagem) }}"
                                        alt="{{ $produto->nome }}" class="img-thumbnail rounded shadow-sm"
                                        style="max-height: 350px; object-fit: contain;">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <span>Sem imagem disponível</span>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-7 p-4 p-lg-5">
                                <div class="mb-4">
                                    <h5 class="text-uppercase text-muted small fw-bold mb-3">Descrição do Produto:
                                        {{ $produto->nome }}</h5>
                                    <div class="text-dark lh-base">
                                        {!! nl2br(e($produto->descricao)) !!}
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-1 small">SKU / Código</p>
                                        <p class="fw-bold">{{ $produto->sku ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="text-muted mb-0 small">Categoria</p>
                                            <button class="btn btn-sm btn-link text-decoration-none p-0" type="button"
                                                style="transition: transform 0.2s;"
                                                onmouseover="this.style.transform='scale(1.1)'"
                                                onmouseout="this.style.transform='scale(1)'" data-bs-toggle="collapse"
                                                data-bs-target="#collapseNovaCategoria">
                                                <i class="bi bi-plus-circle"></i> <small>Nova Categoria</small>
                                            </button>
                                        </div>

                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                                <button class="btn btn-sm btn-link text-decoration-none p-0" type="button"
                                                    style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.1)'"
                                                    onmouseout="this.style.transform='scale(1)'" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseAlterarCategoria">
                                                    {{ $produto->categoria->nome ?? 'Sem categoria' }}
                                                </button>
                                            </span>
                                        </div>

                                        <div class="collapse mt-2" id="collapseNovaCategoria">
                                            <div class="card card-body bg-light border-dashed p-2">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="nome_categoria" form="formNovaCategoria"
                                                        class="form-control" placeholder="Nome da nova categoria">
                                                    <button class="btn btn-success" type="submit" form="formNovaCategoria"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseNovaCategoria"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse mt-2" id="collapseAlterarCategoria">
                                            <div class="card card-body bg-light border-dashed p-2">
                                                <div class="input-group input-group-sm">
                                                    <select name="categoria_id" form="formUpdateCategoria"
                                                        class="form-select">
                                                        @foreach ($categorias as $cat)
                                                            <option value="{{ $cat->id }}"
                                                                {{ $produto->categoria_id == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->nome }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-success" type="submit"
                                                        form="formUpdateCategoria" style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseAlterarCategoria"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-box-seam me-2"></i>Gestão de Estoque
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Quantidade</th>
                                        <th>Preço de Venda / Preço de Custo</th>
                                        <th>Última Atualização</th>
                                        <th class="text-center pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produto->estoques as $estoque)
                                        <tr>
                                            <td>
                                                <span
                                                    class="fs-5">{{ number_format($estoque->quantidade, 0, ',', '.') }}</span>
                                                <small class="text-muted">{{ $estoque->medida }}</small>
                                            </td>
                                            <td>{{ $estoque->preco_venda() }}R$ por {{ $estoque->medida }} / {{ $estoque->preco_custo() }}R$ no total</td>
                                            <td>{{ $estoque->updated_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-center pe-4">
                                                @if ($estoque->quantidade <= ($estoque->estoque_minimo ?? 5))
                                                    <span class="badge bg-danger-subtle text-danger">Estoque Baixo</span>
                                                @else
                                                    <span class="badge bg-success-subtle text-success">Estoque Adequado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-info-circle me-1"></i> Nenhum registro de estoque
                                                encontrado para este produto.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form
        action="{{ route($bag['route'] . '.update', ['loja' => session('loja_id'), 'categoria' => $produto->categoria->id, 'produto' => $produto->id]) }}"
        method="POST" id="formUpdateCategoria">
        @csrf
        @method('PUT')
        <input type="hidden" name="nome" value="{{ $produto->nome }}">
    </form>
    <form action="{{ route($bag['route'] . '.store.categoria', ['loja' => session('loja_slug')]) }}" method="POST"
        id="formNovaCategoria" style="display: none;">
        @csrf
    </form>
@endsection
