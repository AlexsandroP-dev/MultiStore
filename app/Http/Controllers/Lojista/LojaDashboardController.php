<?php

namespace App\Http\Controllers\Lojista;

use App\Http\Controllers\Controller;
use App\Models\Lojas\Loja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LojaDashboardController extends Controller
{
    protected $bag = [
        'view' => 'lojas',
        'route' => 'loja.dashboard',
        'title' => 'Dashboard',
        'subtitle' => 'Dashboard',
    ];

    public function __construct()
    {
        View::share('bag', $this->bag);
    }

    public function index(Loja $loja)
    {
        return view($this->bag['view'] . '.dashboard');
    }
}
