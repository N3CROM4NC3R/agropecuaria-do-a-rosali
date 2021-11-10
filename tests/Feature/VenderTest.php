<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Producto;
use App\Configuracion;
use App\User;
use App\Cliente;

use Auth;


class VenderTest extends TestCase
{



    use RefreshDatabase, WithFaker;

    
    
    
    public function test_un_administrador_puede_agregar_producto_de_venta(){

        $this->signIn();
        
        $producto = factory(Producto::class)->create();
        $producto = Producto::find($producto->id);

        
        $response = $this->post("/productoDeVenta", ["codigo" => $producto->codigo_barras]);
        $response->assertStatus(302);
        $producto->cantidad = 1;
        
        
        
        $response->assertSessionHas(["productos" => [ $producto ]]);
    }
    public function test_un_administrador_puede_agregar_2_productos_de_ventas(){
        $this->withoutExceptionHandling();
        $this->signIn();
        
        $iva = factory(Configuracion::class)->create(
            [
            "nombre" => "iva",
            "valor"  => $this->faker->randomFloat(2, 0, 1),
            ]
        );
            
        $productos = factory(Producto::class,2)->create();
        $productos[0]->cantidad = 1;
        $productos[1]->cantidad = 1;
        $productos = [$productos[0],$productos[1]];
        
        $response = $this->withSession(["productos"=>$productos])
        ->get("/vender");
        
        $response->assertStatus(200);
        
        
        
        foreach($productos as $producto){
            //Añadiendo el atributo de cantidad de cada modelo
            

            $response->assertSee($producto->codigo_barras);
            $response->assertSee($producto->descripcion);
            $response->assertSee($producto->precio_venta);
        }
        
        $total = number_format($productos[0]->precio_venta + $productos[1]->precio_venta,2);
        
        $iva = number_format($total * $iva->valor,2);
        
        $total_neto = number_format($total + $iva,2);
        
        $response->assertSee($total);
        $response->assertSee($iva);
        $response->assertSee($total_neto);
    }
    
    public function test_un_administrador_puede_terminar_una_venta(){
        $this->withoutExceptionHandling();

        $this->signIn();

        $configuracion_iva = factory(Configuracion::class)->create(
            [
            "nombre" => "iva",
            "valor"  => $this->faker->randomFloat(2, 0, 1),
            ]
        );

        $cliente = factory(Cliente::class)->create();

        $usuario = Auth::user();

        $productos = factory(Producto::class,2)->create();
        $array_productos = [];

        $precio_bruto = 0;

        foreach($productos as $producto){
            $producto->cantidad = 2;
            array_push($array_productos,$producto);
            $precio_bruto += number_format($producto->precio_venta * $producto->cantidad,2);
            
        }
        $iva = number_format($precio_bruto * $configuracion_iva->valor,2);
        $precio_neto = number_format($iva + $precio_bruto,2);


        $response = $this->withSession(["productos" => $array_productos])
            ->post("/terminarOCancelarVenta",["accion" => "terminar","id_cliente" => $cliente->id,"id_user" => $usuario->id]);

        $response->assertStatus(302);
        $this->assertDatabaseHas("productos_vendidos",["id" => $productos[0]->id]);
        $this->assertDatabaseHas("productos_vendidos",["id" => $productos[1]->id]);

        $this->assertDatabaseHas("ventas",["precio_bruto" => $precio_bruto,"iva" => $iva, "precio_neto" => $precio_neto]);


    }
    


        
        
        /* public function test_un_administrador_puede_quitar_producto_de_venta(){
            

    } */
}
