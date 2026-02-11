<?php

namespace App\Http\Controllers\Lojista\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lojas\ProdutoRequest;
use App\Models\Lojas\Categoria;
use App\Models\Lojas\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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
        $produtos = $this->produtos->paginate(30);
        $links = $produtos->appends($request->except('page'));
        return view($this->bag['view'] . '.index', compact('produtos', 'links'));
    }

    public function create()
    {
        $categorias = $this->categorias->where('loja_id', session('loja_id'))->get();
        return view($this->bag['view'] . '.create', compact('categorias'));
    }

    public function show($loja, $categoria, Produto $produto)
    {
        return view($this->bag['view'] . '.show', compact('produto'));
    }

    public function store(ProdutoRequest $request)
    {
        DB::beginTransaction();
        try {
            $dados = $request->validated();
            $categoria = $this->categorias->where('id', $dados['categoria_id'])->where('loja_id', session('loja_id'))->firstOrFail();
            if ($request->hasFile('diretorio_imagem') && $request->file('diretorio_imagem')->isValid()) {
                $path = $request->file('diretorio_imagem')->store('lojas/'
                    . session('loja_id') . '/categorias' . '/'
                    . $categoria->id . '/produtos', 'public');
                $dados['diretorio_imagem'] = $path;
            }
            $dados['loja_id'] = session('loja_id');
            $produto = $this->produtos->create($dados);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', [
                'loja' => session('loja_slug'), 
                'categoria' => $categoria->slug, 
                'produto' => $produto->id])
                ->with('success', 'Produto cadastrado com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao cadastrar novo produto!']);
        }
    }

    public function edit($loja, $categoria, Produto $produto)
    {
        return view($this->bag['view'] . '.edit', compact('produto'));
    }

    public function update(ProdutoRequest $request, $loja, $categoria, Produto $produto)
    {
        DB::beginTransaction();
        try {
            $dados = $request->validated();
            $categoria = $this->categorias->where('id', $dados['categoria_id'])->where('loja_id', session('loja_id'))->firstOrFail();
            if ($request->hasFile('diretorio_imagem') && $request->file('diretorio_imagem')->isValid()) {
                $path = $request->file('diretorio_imagem')->store('lojas/'
                    . session('loja_id') . '/categorias' . '/'
                    . $categoria->id . '/produtos', 'public');
                $dados['diretorio_imagem'] = $path;
            }
            $dados['loja_id'] = session('loja_id');
            $produto = $this->produtos->where('id', $produto->id)->update($dados);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', [
                'loja' => session('loja_slug'), 
                'categoria' => $categoria->slug, 
                'produto' => $produto->id])
                ->with('success', 'Dados do produto alterados com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput();
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
}
