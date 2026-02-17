<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MainDashboardController extends Controller
{
    protected $bag = [
        'view' => 'sistema.main',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'subtitle' => 'Dashboard',
    ];

    public function __construct()
    {
        View::share('bag', $this->bag);
    }

    public function index()
    {
        return view($this->bag['view'] . '.dashboard');
    }
}
