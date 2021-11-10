<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Configuracion;
use App\Http\Requests\ConfiguracionUpdateRequest;

class ConfiguracionesController extends Controller
{
    public function index(Request $request)
    {
        
        $configuracion_iva = Configuracion::where(["nombre" => "iva"])->first();

        return view("configuraciones.configuraciones_index", ["configuracion_iva" => $configuracion_iva]);
    }

    public function update(ConfiguracionUpdateRequest $request){

        $datos = $request->validated();

        $configuracion_iva = Configuracion::where(["nombre" => "iva"])->first();


        $configuracion_iva->valor = $datos["iva"]/100;

        $configuracion_iva->saveOrFail();

        return redirect()->route("configuraciones.index");


    }
}
