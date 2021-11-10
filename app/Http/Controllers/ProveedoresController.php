<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;

use App\Http\Requests\ProveedorCreateRequest;
use App\Http\Requests\ProveedorUpdateRequest;

class ProveedoresController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("proveedores.proveedores_index", ["proveedores" => Proveedor::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("proveedores.proveedores_create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProveedorCreateRequest $request)
    {
        $datos = $request->validated();

        (new Proveedor($datos))->saveOrFail();
        return redirect()->route("proveedores.index")->with("mensaje", "Proveedor agregado");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Proveedor $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        return view("proveedores.proveedores_edit", ["proveedor" => $proveedor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Proveedor $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(ProveedorUpdateRequest $request, Proveedor $proveedor)
    {

        $datos = $request->validated();

        $proveedor->fill($datos);
        $proveedor->saveOrFail();
        return redirect()->route("proveedores.index")->with("mensaje", "Proveedor actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Proveedor $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect()->route("proveedores.index")->with("mensaje", "Proveedor eliminado");
    }
}
