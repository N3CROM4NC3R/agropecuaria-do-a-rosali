<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route("home");
});

Auth::routes([
    "reset" => false,// no pueden olvidar contraseña
    "register" => false
]);

Route::get('/home', 'HomeController@index')->name('home');
// Permitir logout con petición get
Route::get("/logout", function () {
    Auth::logout();
    return redirect()->route("login");
})->name("logout");


Route::middleware("auth")
    ->group(function () {
        Route::resource("clientes", "ClientesController");
        
        


        Route::get("/usuarios", "UserController@index")->name("usuarios.index");
        Route::get("/usuarios/{user}/edit", "UserController@edit")->name("usuarios.edit");
        Route::get("/usuarios/create", "UserController@create")->name("usuarios.create");
        Route::post("/usuarios", "UserController@store")->name("usuarios.store");
        Route::put("/usuarios/{user}", "UserController@update")->name("usuarios.update");
        Route::delete("/usuarios/{user}", "UserController@destroy")->name("usuarios.destroy");

        
        
        Route::get("/productos", "ProductosController@index")->name("productos.index");
        Route::get("/productos/{producto}/edit", "ProductosController@edit")->name("productos.edit");
        Route::get("/productos/create", "ProductosController@create")->name("productos.create");
        Route::post("/productos", "ProductosController@store")->name("productos.store");
        Route::put("/productos/{producto}", "ProductosController@update")->name("productos.update");
        Route::delete("/productos/{producto}", "ProductosController@destroy")->name("productos.destroy");

        Route::get("/proveedores", "ProveedoresController@index")->name("proveedores.index");
        Route::get("/proveedores/{proveedor}/edit", "ProveedoresController@edit")->name("proveedores.edit");
        Route::get("/proveedores/create", "ProveedoresController@create")->name("proveedores.create");
        Route::post("/proveedores", "ProveedoresController@store")->name("proveedores.store");
        Route::put("/proveedores/{proveedor}", "ProveedoresController@update")->name("proveedores.update");
        Route::delete("/proveedores/{proveedor}", "ProveedoresController@destroy")->name("proveedores.destroy");


        
        Route::get("/ventas", "VentasController@index")->name("ventas.index");
        Route::get("/ventas/{venta}", "VentasController@show")->name("ventas.show");
        Route::delete("/ventas/{venta}", "VentasController@destroy")->name("ventas.destroy");
        Route::get("/ventas/ticket", "VentasController@ticket")->name("ventas.ticket");


        Route::get("/configuraciones", "ConfiguracionesController@index")->name("configuraciones.index");
        Route::put("/configuraciones", "ConfiguracionesController@update")->name("configuraciones.update");

        Route::get("/vender", "VenderController@index")->name("vender.index");
        Route::post("/productoDeVenta", "VenderController@agregarProductoVenta")->name("agregarProductoVenta");
        Route::delete("/productoDeVenta", "VenderController@quitarProductoDeVenta")->name("quitarProductoDeVenta");
        Route::post("/terminarOCancelarVenta", "VenderController@terminarOCancelarVenta")->name("terminarOCancelarVenta");
    });


Route::get("/install",function(){
    Artisan::call("migrate:refresh --seed");
});