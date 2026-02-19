<?php

namespace App\Http\Controllers\Lojista\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lojas\ColaboradorRequest;
use App\Models\Lojas\Cargo;
use App\Models\Lojas\CargosLojista;
use App\Models\Lojas\Loja;
use App\Models\Lojas\Lojista;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class ColaboradorController extends Controller
{
    protected $colaboradores;
    protected $cargos;
    protected $bag = [
        'view' => 'lojas.colaboradores',
        'route' => 'loja.dashboard.colaboradores',
        'routeCargo' => 'loja.dashboard.colaboradores.cargo',
        'title' => 'Colaboradores',
        'subtitle' => 'todos os colaboradores',
        'section' => [
            'index' => 'Colaboradores Cadastrados',
            'create' => 'Cadastrar Colaborador',
            'edit' => 'Editar Colaborador',
            'show' => 'Visualizando Colaborador'
        ]
    ];

    public function __construct(Lojista $colaboradores, Cargo $cargos)
    {
        View::share('bag', $this->bag);
        $this->colaboradores = $colaboradores;
        $this->cargos = $cargos;
    }

    public function index()
    {
        $colaboradores = $this->colaboradores->with('user', 'cargos')->where('loja_id', session('loja_id'))->get();
        $cargos = $this->cargos->where('loja_id', session('loja_id'))->get();
        return view($this->bag['view'] . '.index', compact('colaboradores', 'cargos'));
    }

    public function store(ColaboradorRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $colaborador = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $this->colaboradores->Create([
                'user_id' => $colaborador->id,
                'loja_id' => $loja->id,
                'ativo' => true
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Colaborador cadastrado ao sistema e vinculado a loja com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao criar novo colaborador!']);
        }
    }

    public function vincularColaborador(ColaboradorRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            $colaborador = User::where('email', $request->email)->firstOrFail();

            $this->colaboradores->Create([
                'user_id' => $colaborador->id,
                'loja_id' => $loja->id,
                'ativo' => true
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Colaborador vinculado a loja com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao vincular colaborador!']);
        }
    }

    public function inativarColaborador(Loja $loja, User $colaborador)
    {
        DB::beginTransaction();
        try {
            $this->colaboradores->where('user_id', $colaborador->id)->where('loja_id', $loja->id)->update([
                'ativo' => false
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Colaborador desativado da loja com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao inativar colaborador!']);
        }
    }

    public function reativarColaborador(Loja $loja, User $colaborador)
    {
        DB::beginTransaction();
        try {
            $this->colaboradores->where('user_id', $colaborador->id)->where('loja_id', $loja->id)->update([
                'ativo' => true
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Colaborador reativado na loja com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao reativar colaborador!']);
        }
    }

    public function setCargoColaborador(Request $request, Loja $loja, Lojista $colaborador)
    {
        DB::beginTransaction();
        try {
            CargosLojista::where('lojista_id', $colaborador->id)->delete();
            if ($request->cargos) {
                foreach ($request->cargos as $cargo_id) {
                    CargosLojista::create([
                        'cargo_id' => $cargo_id,
                        'lojista_id' => $colaborador->id
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Cargo ou função atribuído ao colaborador com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao atribuir cargo ou função ao colaborador!']);
        }
    }

    public function setVisualizacao($loja, $modo)
    {
        $modoValido = in_array($modo, ['tabela', 'grid']) ? $modo : 'grid';

        session(['loja_colaboradores_visualizacao' => $modoValido]);

        return redirect()->back();
    }
}
