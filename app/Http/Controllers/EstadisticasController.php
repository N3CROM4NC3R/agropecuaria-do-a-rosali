<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;

use App\ProductoVendido;


class EstadisticasController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    
        $semana = Carbon::now()->subDays(7);
        $mes = Carbon::now()->subDays(30);
        $año = Carbon::now()->subDays(366);
        
      

        $productos_vendidos_semanales = ProductoVendido::datetimeGreaterThan($semana)->get();
        $productos_vendidos_mensuales = ProductoVendido::datetimeGreaterThan($mes)->get();
        $productos_vendidos_anuales   = ProductoVendido::datetimeGreaterThan($año)->get();
        $productos_vendidos = ProductoVendido::all();


        $datos = [
            "productos_vendidos_semanales" => $productos_vendidos_semanales,
            "productos_vendidos_mensuales" => $productos_vendidos_mensuales,
            "productos_vendidos_anuales" => $productos_vendidos_anuales,
            "productos_vendidos" => $productos_vendidos
        ];


        return view('estadisticas',$datos);
    }
}
