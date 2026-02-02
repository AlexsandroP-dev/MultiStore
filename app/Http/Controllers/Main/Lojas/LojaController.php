<?php

namespace App\Http\Controllers\Main\Lojas;

use App\Http\Controllers\Controller;
use App\Models\Lojas\Loja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class LojaController extends Controller
{
    protected $lojas;
    protected $bag = [
        'view' => 'sistema.main.lojas',
        'route' => 'dashboard.lojas',
        'title' => 'Lojas',
        'subtitle' => 'todas as lojas',
        'section' => [
            'index' => 'Lojas Cadastradas',
            'create' => 'Cadastrar Loja',
            'edit' => 'Editar Loja',
            'show' => 'Visualizando Loja'
        ]
    ];

    public function __construct(Loja $lojas)
    {
        View::share('bag', $this->bag);
        $this->lojas = $lojas;
    }

    public function index(Request $request)
    {
        $lojas = $this->lojas->paginate(30);
        $links = $lojas->appends($request->except('page'));
        return view($this->bag['view'] . '.index', compact('lojas', 'links'));
    }

    public function create()
    {
        return view($this->bag['view'] . '.create');
    }

    public function show(Loja $loja)
    {
        return view($this->bag['view'] . '.show', compact($loja));
    }

    public function store(Request $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $this->lojas->create($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    public function edit(Loja $loja)
    {
        return view($this->bag['view'] . '.edit', compact('lojas'));
    }

    public function update(Request $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $loja->update($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Loja $loja) {
        DB::beginTransaction();
        try {
            $loja->delete();
            return redirect()->route($this->bag['route'] . '.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }
}
