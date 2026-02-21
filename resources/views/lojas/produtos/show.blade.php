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
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-box-seam me-2"></i>Gestão de Estoque
                        </h5>
                        @if (!$produto->estoque)
                            <button type="button" class="btn btn-sm btn-primary" style="transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.07)'"
                                onmouseout="this.style.transform='scale(1)'" data-bs-toggle="modal"
                                data-bs-target="#modalNovoEstoque">
                                <i class="bi bi-plus-lg"></i> Novo
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-warning" style="transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.07)'"
                                onmouseout="this.style.transform='scale(1)'" data-bs-toggle="modal"
                                data-bs-target="#modalEditarEstoque">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        {{-- Cabeçalho apenas para Desktop (d-none d-md-block) --}}
                        <div class="d-none d-md-block border-bottom bg-light py-2 px-4">
                            <div class="row fw-bold text-muted small text-uppercase">
                                <div class="col-md-4">Unidade / Medida</div>
                                <div class="col-md-4 text-center">Quantidade & Preços</div>
                                <div class="col-md-4 text-end">Status</div>
                            </div>
                        </div>

                        <div class="list-group list-group-flush">
                            @if ($produto->estoque)
                                <div class="list-group-item p-4">
                                    <div class="row align-items-center g-3">
                                        <div class="col-12 col-md-4">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div>
                                                    <span class="d-block text-muted small">Medida</span>
                                                    <strong
                                                        class="text-dark">{{ config("themes.lojas.configs.unidades_medida.{$produto->estoque->medida}") ?? $produto->estoque->medida }}</strong>
                                                </div>
                                                {{-- <button type="button" class="d-md-none btn btn-sm btn-outline-warning"
                                                    style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.07)'"
                                                    onmouseout="this.style.transform='scale(1)'" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditarEstoque">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </button> --}}
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 text-md-center">
                                            <hr class="d-md-none">
                                            <div class="row">
                                                <div class="col-6 col-md-12">
                                                    <span class="d-block text-muted small">Estoque Disponível</span>
                                                    <span
                                                        class="fs-5 fw-bold">{{ number_format($produto->estoque->quantidade, 2, ',', '.') }}
                                                        {{ $produto->estoque->medida }}</span>
                                                </div>
                                                <div class="col-6 d-md-none border-start ps-3"> {{-- Aparece apenas no Mobile ao lado da Qtd --}}
                                                    <span class="mt-md-2 small text-muted">
                                                        <i class="bi bi-box-seam me-1"></i> Estoque Mínimo:
                                                        {{ number_format($produto->estoque->estoque_minimo, 2, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="d-none d-md-block mt-1 small">
                                                <span class="text-muted">Custo: R$ {{ $produto->estoque->preco_custo() }}</span>
                                                <span class="mx-1">|</span>
                                                <span class="text-success fw-bold">Venda: R$
                                                    {{ $produto->estoque->preco_venda() }}</span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 text-md-end">
                                            <div class="d-flex d-md-block justify-content-between align-items-center">
                                                <div>
                                                    <span class="d-none d-md-block text-muted small mb-1">Situação</span>
                                                    @if ($produto->estoque->quantidade <= $produto->estoque->estoque_minimo)
                                                        <span
                                                            class="badge bg-danger-subtle text-danger p-2 px-2 rounded-pill">
                                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Estoque
                                                            Baixo
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-success-subtle text-success p-2 px-2 rounded-pill">
                                                            <i class="bi bi-check-circle-fill me-1"></i> Estoque
                                                            Adequado
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="mt-md-2 d-none d-md-block small text-muted">
                                                    <i class="bi bi-box-seam me-1"></i> Estoque Mínimo:
                                                    {{ number_format($produto->estoque->estoque_minimo, 2, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 text-md-center">
                                            <hr class="d-md-none">
                                            <div class="d-md-none mt-1 small">
                                                <span class="text-muted">Custo: R$ {{ $produto->estoque->preco_custo() }}</span>
                                                <span class="mx-1">|</span>
                                                <span class="text-success fw-bold">Venda: R$
                                                    {{ $produto->estoque->preco_venda() }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- <button type="button"
                                        class="d-none d-md-block btn btn-sm btn-outline-warning mt-3 mt-md-0 float-end"
                                        style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.07)'"
                                        onmouseout="this.style.transform='scale(1)'" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarEstoque">
                                        <i class="bi bi-pencil"></i> Editar Estoque
                                    </button> --}}
                                </div>
                                <div class="modal fade" id="modalEditarEstoque" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar
                                                    Estoque</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form
                                                action="{{ route($bag['routeEstoque'] . '.update', [
                                                    'loja' => session('loja_slug'),
                                                    'categoria' => $produto->categoria->slug,
                                                    'produto' => $produto->id,
                                                    'estoque' => $produto->estoque->id,
                                                ]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Unidade de Medida</label>
                                                            <select name="medida" class="form-select" required>
                                                                @foreach (config('themes.lojas.configs.unidades_medida') as $valor => $label)
                                                                    <option value="{{ $valor }}"
                                                                        {{ old('medida', $produto->estoque->medida) == $valor ? 'selected' : '' }}>
                                                                        {{ $label }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Quantidade Atual</label>
                                                            <input type="number" name="quantidade" step="0.01"
                                                                class="form-control"
                                                                value="{{ old('quantidade', $produto->estoque->quantidade) }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Preço de Custo</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">R$</span>
                                                                <input type="number" name="preco_custo" step="0.01"
                                                                    class="form-control"
                                                                    value="{{ old('preco_custo', $produto->estoque->preco_custo) }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Preço de Venda</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">R$</span>
                                                                <input type="number" name="preco_venda" step="0.01"
                                                                    class="form-control"
                                                                    value="{{ old('preco_venda', $produto->estoque->preco_venda) }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Estoque Mínimo</label>
                                                            <input type="number" name="estoque_minimo" step="0.01"
                                                                class="form-control"
                                                                value="{{ old('estoque_minimo', $produto->estoque->estoque_minimo) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.09)'"
                                                        onmouseout="this.style.transform='scale(1)'"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-success px-4"
                                                        style="transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.07)'"
                                                        onmouseout="this.style.transform='scale(1)'">Atualizar
                                                        Estoque</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-5 text-center text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-3 opacity-50"></i>
                                    <p>Nenhum registro de estoque encontrado.</p>
                                </div>
                            @endif
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
    <div class="modal fade" id="modalNovoEstoque" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Cadastrar Estoque</h5>
                    <button type="button" class="btn-close btn-close-white" style="transition: transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form
                    action="{{ route($bag['routeEstoque'] . '.store', ['loja' => session('loja_slug'), 'categoria' => $produto->categoria->slug, 'produto' => $produto->id]) }}"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Unidade de Medida</label>
                                <select name="medida" class="form-select" required>
                                    <option value="" selected disabled>Selecione...</option>
                                    @foreach (config('themes.lojas.configs.unidades_medida') as $valor => $label)
                                        <option value="{{ $valor }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Quantidade Inicial</label>
                                <input type="number" name="quantidade" step="0.01" class="form-control"
                                    placeholder="0,00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Preço de Custo</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="preco_custo" step="0.01" class="form-control"
                                        placeholder="0,00" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Preço de Venda</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="preco_venda" step="0.01" class="form-control"
                                        placeholder="0,00" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Estoque Mínimo</label>
                                <input type="number" name="estoque_minimo" step="0.01" class="form-control"
                                    value="5">
                                <div class="form-text">Você será avisado quando o estoque atingir este valor.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.09)'" onmouseout="this.style.transform='scale(1)'"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4" style="transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.07)'"
                            onmouseout="this.style.transform='scale(1)'">Salvar Estoque</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                // Se houver erro de validação, verifica qual formulário estava ativo
                // Você pode diferenciar se quiser, ou abrir o de edição que é o mais comum
                var myModal = new bootstrap.Modal(document.getElementById('modalEditarEstoque'));
                myModal.show();
            @endif
        });
    </script>
@endpush
