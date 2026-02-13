@extends('layouts.lojas.page')

@section('content')
    <div class="container-fluid py-4">
        @include('utils.layout.alertsCustom')
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-primary">Editar Produto</h5>
                            <small class="text-muted">Atualize as informações do produto
                                <strong>{{ $produto->nome }}</strong>.</small>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form
                            action="{{ route($bag['route'] . '.update', ['loja' => session('loja_slug'), 'categoria' => $produto->categoria->slug ?? $produto->categoria_id, 'produto' => $produto->slug]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label fw-semibold">Nome do produto</label>
                                    <input type="text" name="nome" id="nome"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        value="{{ old('nome', $produto->nome) }}" required>
                                    @include('utils.form.error', ['param' => 'nome'])
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="categoria_id" class="form-label fw-semibold mb-0">Categoria</label>
                                        <button type="button"
                                            class="btn btn-sm btn-link text-primary p-0 ms-2 text-decoration-none"
                                            data-bs-toggle="collapse" data-bs-target="#collapseNovaCategoria"
                                            style="transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                            <i class="bi bi-plus-circle me-1"></i>Nova Categoria
                                        </button>
                                    </div>
                                    <select name="categoria_id" id="categoria_id"
                                        class="form-select @error('categoria_id') is-invalid @enderror">
                                        @foreach ($categorias as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('categoria_id', $produto->categoria_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('utils.form.error', ['param' => 'categoria_id'])

                                    <div class="collapse mt-3" id="collapseNovaCategoria">
                                        <div class="card card-body bg-light border-0 shadow-sm">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="nome_categoria" form="formNovaCategoria"
                                                    class="form-control form-control-sm"
                                                    placeholder="Nome da nova categoria">
                                                <button class="btn btn-sm btn-success" type="submit"
                                                    form="formNovaCategoria" style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.1)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                                    <i class="bi bi-check-lg"></i> Salvar
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
                                </div>

                                <div class="col-md-12">
                                    <label for="descricao" class="form-label fw-semibold">Descrição</label>
                                    <textarea name="descricao" id="descricao" rows="4" class="form-control">{{ old('descricao', $produto->descricao) }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label for="diretorio_imagem" class="form-label fw-semibold">Imagem do Produto</label>
                                    <div
                                        class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                                        @if ($produto->diretorio_imagem)
                                            <div class="text-center">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $produto->diretorio_imagem) }}"
                                                        class="img-thumbnail shadow-sm"
                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark border border-light">
                                                        Atual
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1 w-100">
                                            <input type="file" name="diretorio_imagem" id="diretorio_imagem"
                                                class="form-control">
                                            <p class="text-muted small mb-0">Selecione apenas se desejar <strong>substituir</strong> a imagem
                                                atual.</p>
                                            <p class="text-muted small mb-0">Formatos aceitos: JPG, JPEG, PNG. Tamanho máx:
                                                3MB.</p>
                                            <p class="text-muted small">Caso cadastre uma nova categoria, será necessário
                                                selecionar a imagem novamente.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('utils.form.error', ['param' => 'diretorio_imagem'])
                            <hr class="my-4 text-muted">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route($bag['route'] . '.show', ['loja' => session('loja_slug'), 'categoria' => $produto->categoria->slug ?? $produto->categoria_id, 'produto' => $produto->slug]) }}"
                                    class="btn btn-light border" style="transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">Cancelar</a>
                                <button type="submit" class="btn btn-success px-4" style="transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="bi bi-save me-1"></i> Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route($bag['route'] . '.store.categoria', ['loja' => session('loja_slug')]) }}" method="POST"
        id="formNovaCategoria" style="display: none;">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('formNovaCategoria').addEventListener('submit', function(e) {
            // Captura os dados do formulário de produto
            const formProduto = document.querySelector('form[action*="update"]');
            const formData = new FormData(formProduto);

            // Adiciona cada campo do produto como um input hidden no form de categoria
            for (let [key, value] of formData.entries()) {
                if (!['_token', '_method', 'diretorio_imagem'].includes(key) && value !== "") {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = key;
                    hiddenInput.value = value;
                    this.appendChild(hiddenInput);
                }
            }
        });
    </script>
@endpush
