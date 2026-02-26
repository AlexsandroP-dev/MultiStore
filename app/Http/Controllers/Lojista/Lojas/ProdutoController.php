<?php

namespace App\Http\Controllers\Lojista\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lojas\ProdutoRequest;
use App\Models\Lojas\Categoria;
use App\Models\Lojas\Loja;
use App\Models\Lojas\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ProdutoController extends Controller
{
    protected $produtos;
    protected $categorias;
    protected $bag = [
        'view' => 'lojas.produtos',
        'route' => 'loja.dashboard.produtos',
        'routeColaborador' => 'loja.dashboard.show.colaborador',
        'routeCargo' => 'loja.dashboard.show.cargo',
        'routeEstoque' => 'loja.dashboard.produtos.show.estoque',
        'title' => 'Produtos',
        'subtitle' => 'todos os produtos',
        'section' => [
            'index' => 'Produtos Cadastrados',
            'create' => 'Cadastrar Produto',
            'edit' => 'Editar Produto',
            'show' => 'Visualizando Produto'
        ]
    ];

    public function __construct(Produto $produtos, Categoria $categorias)
    {
        View::share('bag', $this->bag);
        $this->produtos = $produtos;
        $this->categorias = $categorias;
    }

    public function index(Request $request)
    {
        $catDoProduto = $request->input('categoria') ?? null;
        $nomeDoProduto = $request->input('nome') ?? null;
        $produtos = $this->produtos->with('categoria', 'estoque')->where('loja_id', session('loja_id'))
            ->when($catDoProduto, function ($q) use ($catDoProduto) {
                return $q->whereRelation('categoria', 'nome', '=', $catDoProduto);
            })
            ->when($nomeDoProduto, function ($q) use ($nomeDoProduto) {
                return $q->where('nome', 'ilike', '%' . $nomeDoProduto . '%');
            })
            ->paginate($request->qtd ?? 15)->withQueryString();
        $links = $produtos->appends($request->except('page'));
        $categorias = $this->categorias->where('loja_id', session('loja_id'))->where('ativo', true)->get();
        return view($this->bag['view'] . '.index', compact('produtos', 'links', 'categorias'));
    }

    public function create()
    {
        $categorias = $this->categorias->where('loja_id', session('loja_id'))->get();
        return view($this->bag['view'] . '.create', compact('categorias'));
    }

    public function show(Loja $loja, Categoria $categoria, Produto $produto)
    {
        $categorias = $this->categorias->where('loja_id', session('loja_id'))->get();
        $produto = $this->produtos->with(['categoria', 'estoque'])->where('id', $produto->id)->firstOrFail();
        return view($this->bag['view'] . '.show', compact('produto', 'categorias'));
    }

    public function store(ProdutoRequest $request)
    {
        DB::beginTransaction();
        try {
            $dados = $request->validated();
            $categoria = $this->categorias->where('id', $dados['categoria_id'])->where('loja_id', session('loja_id'))->firstOrFail();

            if ($request->hasFile('diretorio_imagem') && $request->file('diretorio_imagem')->isValid()) {
                $file = $request->file('diretorio_imagem');
                $folder = 'lojas/' . session('loja_id') . '/produtos';
                $filename = $dados['nome'] . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                $dados['diretorio_imagem'] = $path;
            }

            $produto = $this->produtos->create($dados + [
                'slug' => Str::slug($dados['nome']),
                'loja_id' => session('loja_id'),
            ]);

            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', [
                'loja' => session('loja_slug'),
                'categoria' => $categoria->slug,
                'produto' => $produto->slug
            ])
                ->with('success', 'Produto cadastrado com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao cadastrar novo produto!']);
        }
    }

    public function edit(Loja $loja, Categoria $categoria, Produto $produto)
    {
        $categorias = $this->categorias->where('loja_id', session('loja_id'))->get();
        return view($this->bag['view'] . '.edit', compact('produto', 'categorias'));
    }

    public function update(ProdutoRequest $request, Loja $loja, Categoria $categoria, Produto $produto)
    {
        DB::beginTransaction();
        try {
            $dados = $request->validated();

            if ($request->hasFile('diretorio_imagem') && $request->file('diretorio_imagem')->isValid()) {
                // Apaga a imagem antiga se ela existir
                if ($produto->diretorio_imagem) {
                    Storage::disk('public')->delete($produto->diretorio_imagem);
                }

                // Sobe a nova para a pasta da loja
                $file = $request->file('diretorio_imagem');
                $folder = 'lojas/' . session('loja_id') . '/produtos';
                $filename = $dados['nome'] . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                $dados['diretorio_imagem'] = $path;
            }

            $produto->update($dados + ['slug' => Str::slug($dados['nome'])]);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', [
                'loja' => session('loja_slug'),
                'categoria' => $categoria->slug,
                'produto' => $produto->slug
            ])
                ->with('success', 'Dados do produto alterados com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao atualizar os dados do produto!']);
        }
    }

    public function storeCategoria(ProdutoRequest $request)
    {
        DB::beginTransaction();
        try {
            $dados = $request->validated();
            $this->categorias->create([
                'nome' => $dados['nome_categoria'],
                'slug' => Str::slug($dados['nome_categoria']),
                'loja_id' => session('loja_id'),
            ]);
            DB::commit();
            return redirect()->back()->withInput()->with('success', 'Categoria criada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao cadastrar nova categoria!']);
        }
    }

    public function setVisualizacao($loja, $modo)
    {
        $modoValido = in_array($modo, ['tabela', 'grid']) ? $modo : 'grid';

        session(['loja_produto_visualizacao' => $modoValido]);

        return redirect()->back();
    }
}
