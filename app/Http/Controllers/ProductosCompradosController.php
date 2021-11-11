<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductoComprado;
use App\Proveedor;
use App\Producto;

use App\Http\Requests\ProductoCompradoCreateRequest;
use App\Http\Requests\ProductoCompradoUpdateRequest;

class ProductosCompradosController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("productos_comprados.productos_comprados_index", ["productos_comprados" => ProductoComprado::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $productos = Producto::all();
        $proveedores = Proveedor::all();

        return view("productos_comprados.productos_comprados_create",["productos" => $productos,"proveedores" => $proveedores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoCompradoCreateRequest $request)
    {
        $datos = $request->validated();

        (new ProductoComprado($datos))->saveOrFail();
        return redirect()->route("productos_comprados.index")->with("mensaje", "Producto comprado agregado");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductoComprado $producto_comprado)
    {

        $productos = Producto::all();
        $proveedores = Proveedor::all();

        return view("productos_comprados.productos_comprados_edit", 
            [
                "producto_comprado" => $producto_comprado,
                "productos" => $productos,
                "proveedores" => $proveedores,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(ProductoCompradoUpdateRequest $request, ProductoComprado $producto_comprado)
    {

        $datos = $request->validated();

        $producto_comprado->fill($datos);
        $producto_comprado->saveOrFail();
        return redirect()->route("productos_comprados.index")->with("mensaje", "Producto comprado actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ProductoComprado $producto_comprado
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductoComprado $producto_comprado)
    {
        $producto_comprado->delete();
        return redirect()->route("productos_comprados.index")->with("mensaje", "Producto comprado eliminado");
    }
}
