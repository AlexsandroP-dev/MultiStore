<?php

namespace App\Http\Controllers\Main\Lojas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Lojas\CargoRequest;
use App\Models\Lojas\Cargo;
use App\Models\Lojas\CargosLojista;
use App\Models\Lojas\Loja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CargoController extends Controller
{
    protected $cargosLojista;
    protected $bag = [
        'view' => 'sistema.main.lojas',
        'route' => 'dashboard.lojas',
        'routeCargo' => 'dashboard.lojas.show.cargo',
    ];

    public function __construct(CargosLojista $cargosLojista)
    {
        View::share('bag', $this->bag);
        $this->cargosLojista = $cargosLojista;
    }

    public function store(CargoRequest $request, Loja $loja)
    {
        DB::beginTransaction();
        try {
            Cargo::create($request->validated() + [
                'loja_id' => $loja->id
            ]);
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Cargo cadastrado com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao criar novo cargo!']);
        }
    }

    public function update(CargoRequest $request, Loja $loja, Cargo $cargo)
    {
        DB::beginTransaction();
        try {
            $cargo->update($request->validated());
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Nome do cargo alterado com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Algum erro aconteceu ao atualizar o cargo!']);
        }
    }

    public function destroy(Loja $loja, Cargo $cargo)
    {
        DB::beginTransaction();
        try {
            $this->cargosLojista->where('cargo_id', $cargo->id)->delete();
            $cargo->delete();
            DB::commit();
            return redirect()->route($this->bag['route'] . '.show', ['loja' => $loja->id])->with('success', 'Cargo excluído com sucesso!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Algum erro aconteceu ao excluir o cargo!']);
        }
    }
}
