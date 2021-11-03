<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Producto;

class ProductoTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_productos(){

        $response = $this->get("/productos");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_productos()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $productos = factory(Producto::class,5)->create();


        $response = $this->get("/productos");

        $response->assertSee($productos[0]->descripcion);


        $response->assertStatus(200);
    }
    public function test_un_administrador_puede_crear_productos()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $producto = factory(Producto::class)->make();

        $data = [
            "descripcion"   => $producto->descripcion,
            "codigo_barras" => $producto->codigo_barras,
            "precio_venta"  => $producto->precio_venta
        ];


        $response = $this->post("/productos",$data);

        $response->assertStatus(302);

        $this->assertDatabaseHas("productos", $data);
    }

    public function test_un_administrator_no_puede_crear_productos_sin_datos(){
        /* $this->withoutExceptionHandling(); */

        $this->signIn();

        $producto = factory(Producto::class)->make();

        $data = [];


        $response = $this->post("/productos",$data);

        $response->assertStatus(302);

    }

    public function test_un_administrador_puede_ver_crear_producto(){

        $this->withoutExceptionHandling();

        $this->signIn();

        $response = $this->get("/productos/create");

        $response->assertStatus(200);

        $response->assertSee("Guardar");


    }

    public function test_un_administrador_puede_editar_productos(){
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $producto_datos = factory(Producto::class)->make();

        $response = $this->put("/productos/".$producto->id,["descripcion" => $producto_datos->descripcion]);
    
        $response->assertStatus(302);

        $this->assertDatabaseHas("productos",["id" => $producto->id,"descripcion" => $producto_datos->descripcion]);
    }

    public function test_un_administrador_no_puede_editar_productos_sin_datos_validos(){
        /* $this->withoutExceptionHandling(); */
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $datos = [
            "descripcion" => "",
            "precio_venta" => "",
            "codigo_barras" => ""
        ];

        $response = $this->put("/productos/".$producto->id,$datos);
        $response->assertStatus(302);


        $this->assertDatabaseMissing("productos",["id" => $producto->id,"descripcion" => ""]);




    }

    public function test_un_administrador_puede_ver_editar_producto(){

/*         $this->withoutExceptionHandling();
 */
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $response = $this->get("/productos/".$producto->id."/edit");

        $response->assertStatus(200);

        $response->assertSee($producto->descripcion);

        $response->assertSee("Guardar");


    }

    /* public function test_un_administrador_puede_ver_informacion_producto(){
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $response = $this->get("/productos/".$producto->id);

        $response->assertStatus(200);

        $response->assertSee($producto->descripcion); 

    } */

    

    public function test_un_administrador_puede_eliminar_productos(){
        $this->signIn();

        $productos = factory(Producto::class,5)->create();

        $producto = $productos[0];
        $response = $this->delete("/productos/" . $producto->id);

        $this->assertDatabaseMissing("productos",["id" => $producto->id]);

    }
}
