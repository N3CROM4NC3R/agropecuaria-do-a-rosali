<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

use App\Http\Requests\ClienteCreateRequest;
use App\Http\Requests\ClienteUpdateRequest;


class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("clientes.clientes_index", ["clientes" => Cliente::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("clientes.clientes_create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteCreateRequest $request)
    {
        $datos = $request->validated();

        (new Cliente($datos))->saveOrFail();
        return redirect()->route("clientes.index")->with("mensaje", "Cliente agregado");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view("clientes.clientes_edit", ["cliente" => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {

        $datos = $request->validated();

        $cliente->fill($datos);
        $cliente->saveOrFail();
        return redirect()->route("clientes.index")->with("mensaje", "Cliente actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route("clientes.index")->with("mensaje", "Cliente eliminado");
    }
}
