<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\ProductoComprado;

class ProductoCompradoTest extends TestCase
{
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_productos_comprados(){
       

        $response = $this->get("/productos-comprados");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_productos_comprados()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $productos_comprados = factory(ProductoComprado::class,5)->create();


        $response = $this->get("/productos-comprados");

        $response->assertSee($productos_comprados[0]->descripcion);


        $response->assertStatus(200);
    }
    public function test_un_administrador_puede_crear_productos_comprados()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $producto_comprado = factory(ProductoComprado::class)->make();

        $data = [
            "precio_unidad"   => $producto_comprado->precio_unidad,
            "cantidad"        => $producto_comprado->cantidad,
            "id_proveedor"    => $producto_comprado->id_proveedor,
            "id_producto"      => $producto_comprado->id_producto
        ];


        $response = $this->post("/productos-comprados",$data);

        $response->assertStatus(302);

        $this->assertDatabaseHas("productos_comprados", $data);
    }

    public function test_un_administrator_no_puede_crear_productos_comprados_sin_datos(){
        /* $this->withoutExceptionHandling(); */

        $this->signIn();

        $producto_comprado = factory(ProductoComprado::class)->make();

        $data = [];


        $response = $this->post("/productos-comprados",$data);

        $response->assertStatus(302);

    }

    public function test_un_administrador_puede_ver_crear_producto_comprado(){

        $this->withoutExceptionHandling();

        $this->signIn();

        $response = $this->get("/productos-comprados/create");

        $response->assertStatus(200);

        $response->assertSee("Guardar");


    }

    public function test_un_administrador_puede_editar_productos_comprados(){
        $this->signIn();

        $producto_comprado = factory(ProductoComprado::class)->create();

        $producto_comprados_datos = factory(ProductoComprado::class)->make();

        $response = $this->put("/productos-comprados/".$producto_comprado->id,["precio_unidad" => $producto_comprados_datos->precio_unidad]);
    
        $response->assertStatus(302);

        $this->assertDatabaseHas("productos_comprados",["id" => $producto_comprado->id,"precio_unidad" => $producto_comprados_datos->precio_unidad]);
    }

    public function test_un_administrador_no_puede_editar_productos_comprados_sin_datos_validos(){
        /* $this->withoutExceptionHandling(); */
        $this->signIn();

        $producto_comprado = factory(ProductoComprado::class)->create();

        $datos = [
            "precio_unidad"   => "",
            "cantidad" => "",
            "id_proveedor"  => "",
            "id_cliente"  => ""
        ];

        $response = $this->put("/productos-comprados/".$producto_comprado->id,$datos);
        $response->assertStatus(302);


        $this->assertDatabaseMissing("productos_comprados",["id" => $producto_comprado->id,"precio_unidad" => ""]);




    }

    public function test_un_administrador_puede_ver_editar_producto(){

/*         $this->withoutExceptionHandling();
 */
        $this->signIn();

        $producto_comprado = factory(ProductoComprado::class)->create();

        $response = $this->get("/productos-comprados/".$producto_comprado->id."/edit");

        $response->assertStatus(200);

        $response->assertSee($producto_comprado->precio_unidad);

        $response->assertSee("Guardar");


    }

    /* public function test_un_administrador_puede_ver_informacion_producto(){
        $this->signIn();

        $producto_comprado = factory(ProductoComprado::class)->create();

        $response = $this->get("/productos-comprados/".$producto_comprado->id);

        $response->assertStatus(200);

        $response->assertSee($producto_comprado->descripcion); 

    } */

    

    public function test_un_administrador_puede_eliminar_productos(){
        $this->signIn();

        $productos_comprados = factory(ProductoComprado::class,5)->create();

        $producto_comprado = $productos_comprados[0];
        $response = $this->delete("/productos-comprados/" . $producto_comprado->id);

        $this->assertDatabaseMissing("productos_comprados",["id" => $producto_comprado->id]);

    }
}
