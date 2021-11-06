<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Cliente;


class ClientTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_clientes(){
        

        $response = $this->get("/clientes");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_clientes()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $clientes = factory(Cliente::class,5)->create();


        $response = $this->get("/clientes");

        $response->assertSee($clientes[0]->nombre);


        $response->assertStatus(200);
    }
    public function test_un_administrador_puede_crear_clientes()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $cliente = factory(Cliente::class)->make();

        $data = [
            "nombre"   => $cliente->nombre,
            "apellido" => $cliente->apellido,
            "cedula"  => $cliente->cedula,
            "email" => $cliente->email,
            "direccion" => $cliente->direccion,
            "telefono" => $cliente->telefono
        ];
        

        $response = $this->post("/clientes",$data);

        $response->assertStatus(302);

        $this->assertDatabaseHas("clientes", ["nombre" => $cliente->nombre]);
    }

    public function test_un_administrador_no_puede_crear_clientes_sin_apellido(){

       
        $this->signIn();

        $cliente = factory(Cliente::class)->make();

        $data = [
            "nombre"   => $cliente->nombre,
            "apellido" => "",
            "cedula"  => $cliente->cedula,
            "email" => $cliente->email,
            "direccion" => $cliente->direccion,
            "telefono" => $cliente->telefono
        ];


        $response = $this->post("/clientes",$data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing("clientes", $data);
    }


    public function test_un_administrator_no_puede_crear_clientes_sin_datos(){
        /* $this->withoutExceptionHandling(); */

        $this->signIn();

        $data = [];

        $response = $this->post("/clientes",$data);

        $response->assertStatus(302);

    }

    public function test_un_administrador_puede_ver_crear_cliente(){

        $this->withoutExceptionHandling();

        $this->signIn();

        $response = $this->get("/clientes/create");

        $response->assertStatus(200);

        $response->assertSee("Guardar");


    }

    public function test_un_administrador_puede_editar_clientes(){
        $this->withoutExceptionHandling();
        $this->signIn();

        $cliente = factory(Cliente::class)->create();

        $cliente_datos = factory(Cliente::class)->make();

        $response = $this->put("/clientes/".$cliente->id,["email" => $cliente_datos->email]);
    
        $response->assertStatus(302);

        $this->assertDatabaseHas("clientes",["id" => $cliente->id,"email" => $cliente_datos->email]);
    }

    public function test_un_administrador_no_puede_editar_clientes_sin_datos_validos(){
        /* $this->withoutExceptionHandling(); */
        $this->signIn();

        $cliente = factory(Cliente::class)->create();

        $datos = [
            "nombre"    => "",
            "apellido"  => "",
            "cedula"    => "",
            "email"     => "",
            "direccion" => "",
            "telefono"  => ""
        ];

        $response = $this->put("/clientes/".$cliente->id,$datos);
        $response->assertStatus(302);


        $this->assertDatabaseMissing("clientes",["id" => $cliente->id,"nombre" => ""]);
    }

    public function test_un_administrador_puede_ver_editar_cliente(){

/*         $this->withoutExceptionHandling();
 */
        $this->signIn();

        $cliente = factory(Cliente::class)->create();

        $response = $this->get("/clientes/".$cliente->id."/edit");

        $response->assertStatus(200);

        $response->assertSee($cliente->email);

        $response->assertSee("Guardar");


    }

    /* public function test_un_administrador_puede_ver_informacion_producto(){
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $response = $this->get("/productos/".$producto->id);

        $response->assertStatus(200);

        $response->assertSee($producto->descripcion); 

    } */

    

    public function test_un_administrador_puede_eliminar_clientes(){
        $this->signIn();

        $clientes = factory(Cliente::class,5)->create();

        $cliente = $clientes[0];
        $response = $this->delete("/clientes/" . $cliente->id);

        $this->assertDatabaseMissing("clientes",["id" => $cliente->id]);

    }
}
