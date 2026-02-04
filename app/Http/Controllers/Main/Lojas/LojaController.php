<?php

namespace App\Http\Controllers\Main\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Lojas\ColaboradorRequest;
use App\Http\Requests\Main\Lojas\LojaRequest;
use App\Models\Lojas\Loja;
use App\Models\Lojas\Lojista;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class LojaController extends Controller
{
    protected $lojas;
    protected $bag = [
        'view' => 'sistema.main.lojas',
        'route' => 'dashboard.lojas',
        'routeColaborador' => 'dashboard.lojas.show.colaborador',
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
        $loja->load('lojistas');
        return view($this->bag['view'] . '.show', compact('loja'));
    }

    public function store(LojaRequest $request)
    {
        DB::beginTransaction();
        try {
            $loja = $this->lojas->create($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Loja cadastrada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    public function edit(Loja $loja)
    {
        return view($this->bag['view'] . '.edit', compact('loja'));
    }

    public function update(LojaRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $loja->update($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Dados da loja alterados com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    public function renew(LojaRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $loja->update($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Prazo da expiração da loja renovado!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Loja $loja)
    {
        DB::beginTransaction();
        try {
            $loja->delete();
            return redirect()->route($this->bag['route'] . '.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function storeColaborador(ColaboradorRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Lojista::Create([
                'user_id' => $user->id,
                'loja_id' => $loja->id,
                'status' => 'Ativo'
            ]);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Colaborador cadastrado ao sistema e vinculado a loja com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao criar novo colaborador!']);
        }
    }

    public function vincularColaborador(ColaboradorRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->firstOrFail();

            Lojista::Create([
                'user_id' => $user->id,
                'loja_id' => $loja->id,
                'status' => 'Ativo'
            ]);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Colaborador vinculado a loja com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao vincular colaborador!']);
        }
    }
}
