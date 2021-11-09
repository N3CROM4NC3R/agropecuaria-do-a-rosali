<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Venta;
use App\ProductoVendido;

class VentaTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_ventas(){

        $response = $this->get("/ventas");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_ventas()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $ventas = factory(Venta::class,5)->create();
        $venta = $ventas[0];

        $response = $this->get("/ventas");

        $response->assertSee($venta->created_at);
        $response->assertSee($venta->cliente->nombre);
        $response->assertSee($venta->precio_bruto);
        $response->assertSee($venta->iva);
        $response->assertSee($venta->precio_neto);
        $response->assertSee($venta->user->name);
    

        $response->assertStatus(200);
    }

    public function test_un_administrador_puede_ver_informacion_venta(){
        $this->withoutExceptionHandling();
        $this->signIn();

        $venta = factory(Venta::class)->create();
        $producto_vendidos = factory(ProductoVendido::class, 5)->create([
            "id_venta" => $venta->id
        ]);


        $response = $this->get("/ventas/".$venta->id);

        $response->assertStatus(200);
        
        foreach($producto_vendidos as $producto_vendido){

            $response->assertSee($producto_vendido->descripcion);
            $response->assertSee($producto_vendido->codigo_barras);
            $response->assertSee($producto_vendido->precio);
            $response->assertSee($producto_vendido->cantidad);
        
        }

        $response->assertSee($venta->precio_neto);


    }



    
}
