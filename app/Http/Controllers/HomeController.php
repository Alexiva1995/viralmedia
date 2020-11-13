<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\TreeController;
use App\Http\Controllers\ServiciosController;

class HomeController extends Controller
{
    public $treeController;
    public $servicioController;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->treeController = new TreeController;
        $this->servicioController = new ServiciosController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        View::share('titleg', '');
        $data = $this->dataDashboard(Auth::id());
        return view('dashboard.index', compact('data'));
    }


    /**
     * Permite obtener la informacion a mostrar en el dashboard
     *
     * @param integer $iduser
     * @return array
     */
    public function dataDashboard(int $iduser):array
    {

        $cantUsers = $this->treeController->getTotalUser($iduser);
        $data = [
            'directos' => $cantUsers['directos'],
            'indirectos' => $cantUsers['indirectos'],
            'wallet' => Auth::user()->wallet,
            'balance' => Auth::user()->balance,
            'tickets' => 0,
            'comisiones' => 0,
            'ordenes' => $this->servicioController->getTotalOrdenes($iduser),
            'usuario' => Auth::user()->fullname
        ];

        return $data;
    }
}
