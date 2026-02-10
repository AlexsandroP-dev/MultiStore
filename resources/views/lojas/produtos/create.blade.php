@extends('layouts.lojas.page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary">Cadastrar Novo Produto</h5>
                        <small class="text-muted">Preencha os dados abaixo para configurar seu produto.</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route($bag['route'] . '.store', ['loja' => session('loja_slug')]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label fw-semibold">Nome do produto</label>
                                    <input type="text" name="nome" id="nome"
                                        class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}"
                                        required>
                                    @include('utils.form.error', ['param' => 'nome'])
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="categoria_id" class="form-label fw-semibold mb-0">Categoria</label>
                                        <button class="btn btn-sm btn-link text-primary p-0 ms-2 text-decoration-none"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategoria"
                                            aria-expanded="false" style="transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                            <i class="bi bi-plus-circle me-1"></i>Nova Categoria
                                        </button>
                                    </div>
                                    <select name="categoria_id" id="categoria_id"
                                        class="form-select @error('categoria_id') is-invalid @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach ($categorias as $item)
                                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                        @endforeach
                                    </select>
                                    @include('utils.form.error', ['param' => 'categoria_id'])
                                    <div class="collapse mt-3" id="collapseCategoria">
                                        <div class="card card-body bg-light border-0 shadow-sm">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="nome_categoria" form="formNovaCategoria"
                                                    class="form-control form-control-sm" placeholder="Nome da categoria (ex: Adesivos)"
                                                    required>
                                                <button class="btn btn-success" type="submit" form="formNovaCategoria"
                                                    style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.1)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                                    <i class="bi bi-check-lg"></i> Salvar
                                                </button>
                                                <button class="btn btn-outline-secondary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseCategoria"
                                                    style="transition: transform 0.2s;"
                                                    onmouseover="this.style.transform='scale(1.1)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @include('utils.form.error', ['param' => 'nome_categoria'])
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="descricao" class="form-label fw-semibold">Descrição</label>
                                    <textarea name="descricao" id="descricao" rows="3" class="form-control">{{ old('descricao') }}</textarea>
                                </div>
                                @include('utils.form.error', ['param' => 'descricao'])
                                <div class="col-md-12">
                                    <label for="diretorio_imagem" class="form-label fw-semibold">Imagem do Produto</label>
                                    <input type="file" name="diretorio_imagem" id="diretorio_imagem"
                                        class="form-control @error('diretorio_imagem') is-invalid @enderror">
                                    <small class="text-muted">Formatos aceitos: JPG, JPEG, PNG. Tamanho máx: 3MB.</small>
                                </div>
                                @include('utils.form.error', ['param' => 'diretorio_imagem'])
                                <hr class="my-4 text-muted">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route($bag['route'] . '.index', ['loja' => session('loja_slug')]) }}"
                                        class="btn btn-light border" style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.1)'"
                                        onmouseout="this.style.transform='scale(1)'">Cancelar</a>
                                    <button type="submit" class="btn btn-success px-4" style="transition: transform 0.2s;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-check2-circle me-1"></i> Salvar Loja
                                    </button>
                                </div>
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

@push('css')
    <style>
        /* Mobile: Ajustes para o modo empilhado */
        @media (max-width: 767.98px) {
            .border-column-fix {
                border-radius: 0.375rem 0.375rem 0 0 !important;
                border-bottom: none !important;
                width: 100%;
                text-align: left;
                justify-content: flex-start;
            }

            .input-column-fix {
                border-radius: 0 0 0.375rem 0.375rem !important;
                width: 100%;
            }
        }

        /* Desktop: Força o comportamento original do input-group (span ao lado do input) */
        @media (min-width: 768px) {
            .input-group.flex-md-row {
                flex-wrap: nowrap !important;
            }

            .border-column-fix {
                border-radius: 0.375rem 0 0 0.375rem !important;
                border-bottom: 1px solid #dee2e6 !important;
                width: auto;
            }

            .input-column-fix {
                border-radius: 0 0.375rem 0.375rem 0 !important;
                flex: 1 1 auto;
                width: 1%;
            }
        }
    </style>
@endpush
