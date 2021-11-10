<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Proveedor;

class ProveedorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_proveedores(){
        

        $response = $this->get("/proveedores");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_proveedores()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $proveedores = factory(Proveedor::class,5)->create();


        $response = $this->get("/proveedores");

        $response->assertSee($proveedores[0]->nombre);


        $response->assertStatus(200);
    }
    public function test_un_administrador_puede_crear_proveedores()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $proveedor = factory(Proveedor::class)->make();

        $data = [
            "nombre"   => $proveedor->nombre,
            "apellido" => $proveedor->apellido,
            "cedula"  => $proveedor->cedula,
            "direccion" => $proveedor->direccion,
            "telefono" => $proveedor->telefono
        ];
        

        $response = $this->post("/proveedores",$data);

        $response->assertStatus(302);

        $this->assertDatabaseHas("proveedores", ["nombre" => $proveedor->nombre]);
    }

    public function test_un_administrador_no_puede_crear_proveedores_sin_apellido(){

       
        $this->signIn();

        $proveedor = factory(Proveedor::class)->make();

        $data = [
            "nombre"   => $proveedor->nombre,
            "apellido" => "",
            "cedula"  => $proveedor->cedula,
            "direccion" => $proveedor->direccion,
            "telefono" => $proveedor->telefono
        ];


        $response = $this->post("/proveedores",$data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing("proveedores", $data);
    }


    public function test_un_administrator_no_puede_crear_proveedores_sin_datos(){
        /* $this->withoutExceptionHandling(); */

        $this->signIn();

        $data = [];

        $response = $this->post("/proveedores",$data);

        $response->assertStatus(302);

    }

    public function test_un_administrador_puede_ver_crear_proveedor(){

        $this->withoutExceptionHandling();

        $this->signIn();

        $response = $this->get("/proveedores/create");

        $response->assertStatus(200);

        $response->assertSee("Guardar");


    }

    public function test_un_administrador_puede_editar_proveedores(){
        $this->withoutExceptionHandling();
        $this->signIn();

        $proveedor = factory(Proveedor::class)->create();

        $proveedor_datos = factory(Proveedor::class)->make();

        $response = $this->put("/proveedores/".$proveedor->id,["cedula" => $proveedor_datos->cedula]);
    
        $response->assertStatus(302);

        $this->assertDatabaseHas("proveedores",["id" => $proveedor->id,"cedula" => $proveedor_datos->cedula]);
    }

    public function test_un_administrador_no_puede_editar_proveedores_sin_datos_validos(){
        /* $this->withoutExceptionHandling(); */
        $this->signIn();

        $proveedor = factory(Proveedor::class)->create();

        $datos = [
            "nombre"    => "",
            "apellido"  => "",
            "cedula"    => "",
            "direccion" => "",
            "telefono"  => ""
        ];

        $response = $this->put("/proveedores/".$proveedor->id,$datos);
        $response->assertStatus(302);


        $this->assertDatabaseMissing("proveedores",["id" => $proveedor->id,"nombre" => ""]);
    }

    public function test_un_administrador_puede_ver_editar_proveedor(){

/*         $this->withoutExceptionHandling();
 */
        $this->signIn();

        $proveedor = factory(Proveedor::class)->create();

        $response = $this->get("/proveedores/".$proveedor->id."/edit");

        $response->assertStatus(200);

        $response->assertSee($proveedor->email);

        $response->assertSee("Guardar");


    }

    /* public function test_un_administrador_puede_ver_informacion_producto(){
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $response = $this->get("/productos/".$producto->id);

        $response->assertStatus(200);

        $response->assertSee($producto->descripcion); 

    } */

    

    public function test_un_administrador_puede_eliminar_proveedores(){
        $this->signIn();

        $proveedores = factory(Proveedor::class,5)->create();

        $proveedor = $proveedores[0];
        $response = $this->delete("/proveedores/" . $proveedor->id);

        $this->assertDatabaseMissing("proveedores",["id" => $proveedor->id]);

    }
}
