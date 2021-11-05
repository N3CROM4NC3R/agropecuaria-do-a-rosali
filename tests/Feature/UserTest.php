<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_usuarios(){

        $response = $this->get("/usuarios");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_usuarios()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $usuarios = factory(User::class,5)->create();


        $response = $this->get("/usuarios");

        $response->assertSee($usuarios[0]->email);


        $response->assertStatus(200);
    }
    public function test_un_administrador_puede_crear_usuarios()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $usuario = factory(User::class)->make();

        $data = [
            "name"   => $usuario->name,
            "apellido" => $usuario->apellido,
            "cedula"  => $usuario->cedula,
            "email" => $usuario->email,
            "password" => "secret123",
            "repeatPassword" => "secret123"
        ];


        $response = $this->post("/usuarios",$data);

        $response->assertStatus(302);

        $this->assertDatabaseHas("users", ["name" => $usuario->name]);
    }

    public function test_un_administrador_no_puede_crear_usuarios_sin_apellido(){

       
        $this->signIn();

        $usuario = factory(User::class)->make();

        $data = [
            "name"   => $usuario->name,
            "apellido" => "",
            "cedula"  => $usuario->cedula,
            "email" => $usuario->email,
            "password" => "secret123",
            "repeatPassword" => "secret123"
        ];


        $response = $this->post("/usuarios",$data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing("users", $data);
    }

    public function test_un_administrador_no_puede_crear_usuarios_con_contraseña_repetida_no_igual(){

        
        $this->signIn();

        $usuario = factory(User::class)->make();

        $data = [
            "name"   => $usuario->name,
            "apellido" => $usuario->apellido,
            "cedula"  => $usuario->cedula,
            "email" => $usuario->email,
            "password" => "secret123",
            "repeatPassword" => "Secret123"
        ];


        $response = $this->post("/usuarios",$data);

        $response->assertStatus(302);

        $this->assertDatabaseMissing("users", $data);
    }


    public function test_un_administrator_no_puede_crear_usuarios_sin_datos(){
        /* $this->withoutExceptionHandling(); */

        $this->signIn();

        $data = [];

        $response = $this->post("/usuarios",$data);

        $response->assertStatus(302);

    }

    public function test_un_administrador_puede_ver_crear_usuario(){

        $this->withoutExceptionHandling();

        $this->signIn();

        $response = $this->get("/usuarios/create");

        $response->assertStatus(200);

        $response->assertSee("Guardar");


    }

    public function test_un_administrador_puede_editar_usuarios(){
        $this->signIn();

        $usuario = factory(User::class)->create();

        $usuario_datos = factory(User::class)->make();

        $response = $this->put("/usuarios/".$usuario->id,["email" => $usuario_datos->email]);
    
        $response->assertStatus(302);

        $this->assertDatabaseHas("users",["id" => $usuario->id,"email" => $usuario_datos->email]);
    }

    public function test_un_administrador_no_puede_editar_usuarios_sin_datos_validos(){
        /* $this->withoutExceptionHandling(); */
        $this->signIn();

        $usuario = factory(User::class)->create();

        $datos = [
            "name" => "",
            "apellido" => "",
            "cedula" => "",
            "email" => "",
            "password" => ""
        ];

        $response = $this->put("/usuarios/".$usuario->id,$datos);
        $response->assertStatus(302);


        $this->assertDatabaseMissing("users",["id" => $usuario->id,"name" => ""]);




    }

    public function test_un_administrador_puede_ver_editar_usuario(){

/*         $this->withoutExceptionHandling();
 */
        $this->signIn();

        $usuario = factory(User::class)->create();

        $response = $this->get("/usuarios/".$usuario->id."/edit");

        $response->assertStatus(200);

        $response->assertSee($usuario->email);

        $response->assertSee("Guardar");


    }

    /* public function test_un_administrador_puede_ver_informacion_producto(){
        $this->signIn();

        $producto = factory(Producto::class)->create();

        $response = $this->get("/productos/".$producto->id);

        $response->assertStatus(200);

        $response->assertSee($producto->descripcion); 

    } */

    

    public function test_un_administrador_puede_eliminar_usuarios(){
        $this->signIn();

        $usuarios = factory(User::class,5)->create();

        $usuario = $usuarios[0];
        $response = $this->delete("/usuarios/" . $usuario->id);

        $this->assertDatabaseMissing("users",["id" => $usuario->id]);

    }
}
