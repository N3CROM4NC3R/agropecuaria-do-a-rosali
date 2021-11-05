<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route("home");
});

Auth::routes([
    "reset" => false,// no pueden olvidar contraseña
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



        Route::get("/ventas/ticket", "VentasController@ticket")->name("ventas.ticket");



        Route::resource("ventas", "VentasController");
        Route::get("/vender", "VenderController@index")->name("vender.index");
        Route::post("/productoDeVenta", "VenderController@agregarProductoVenta")->name("agregarProductoVenta");
        Route::delete("/productoDeVenta", "VenderController@quitarProductoDeVenta")->name("quitarProductoDeVenta");
        Route::post("/terminarOCancelarVenta", "VenderController@terminarOCancelarVenta")->name("terminarOCancelarVenta");
    });


Route::get("/install",function(){
    Artisan::call("migrate:refresh --seed");
});