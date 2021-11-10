<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Configuracion;

class ConfiguracionTest extends TestCase
{
    use RefreshDatabase,withFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_un_visitante_no_puede_ver_configuraciones(){
        
        $response = $this->get("/configuraciones");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_configuraciones()
    {

        $this->withoutExceptionHandling();
        $this->signIn();


        $iva = $this->faker->randomNumber(2);
        
        $configuracion_iva = factory(Configuracion::class)->create(["nombre"=>"iva","valor" => $iva/100]);

        $response = $this->get("/configuraciones");

        $response->assertSee("Porcentaje IVA");
        $response->assertSee($iva);


        $response->assertStatus(200);
    }
    
    public function test_un_administrador_puede_editar_configuraciones(){
        $this->withoutExceptionHandling();
        $this->signIn();

        $iva = $this->faker->randomNumber(2);

        $configuracion_iva = factory(Configuracion::class)->create(["nombre"=>"iva","valor" => $iva/100]);

        $iva = $this->faker->randomNumber(2);

        $response = $this->put("/configuraciones/",["iva" => $iva]);
    
        $response->assertStatus(302);

        $this->assertDatabaseHas("configuraciones",["id" => $configuracion_iva->id,"valor" => $iva/100]);
    }

    public function test_un_administrador_no_puede_editar_iva_sin_datos_validos(){

        $this->signIn();

        $iva = $this->faker->randomNumber(2);

        $configuracion_iva = factory(Configuracion::class)->create(["nombre"=>"iva","valor" => $iva]);

        
        $response = $this->put("/configuraciones/",["iva" => -1]);
    
        $response->assertStatus(302);

        $this->assertDatabaseMissing("configuraciones",["id" => $configuracion_iva->id,"valor" => -1/100]);
    }
}
