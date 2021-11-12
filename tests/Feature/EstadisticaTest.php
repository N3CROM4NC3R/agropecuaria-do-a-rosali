<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\ProductoVendido;
use App\Cliente;
use App\Venta;
use App\User;

class EstadisticaTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_un_visitante_no_puede_ver_estadisticas(){
        

        $response = $this->get("/estadisticas");

        $response->assertStatus(302);
    }

    public function test_un_administrador_puede_ver_estadisticas()
    {

        $this->withoutExceptionHandling();
        $this->signIn();

        $productos_vendidos = factory(ProductoVendido::class,5)->create(["codigo_barras" => 1,"descripcion" => "leche"]);


        $response = $this->get("/estadisticas");

        $response->assertSee($productos_vendidos[0]->descripcion);
        $response->assertSee(5);

        $response->assertStatus(200);
    }

    public function test_un_administrador_puede_ver_productos_comprados_semanales_mensuales_anuales(){

        $this->signIn();

        
        $week_ago = $this->faker->dateTimeBetween("-6 days","+0 days");
        $month_ago = $this->faker->dateTimeBetween("-20 days","-8 days");
        $year_ago = $this->faker->dateTimeBetween("-6 months","-31 days");


        $productos_vendidos_semanales = factory(ProductoVendido::class,3)->create(["created_at" => $week_ago]);
        $productos_vendidos_mensuales = factory(ProductoVendido::class,5)->create(["created_at" => $month_ago]);
        $productos_vendidos_anuales   = factory(ProductoVendido::class,10)->create(["created_at" => $year_ago]);
        $response = $this->get("/estadisticas");

        $response->assertSee(5);
        $response->assertSee(8);
        $response->assertSee(18);
    }

    public function test_un_administrador_puede_ver_productos_comprados_por_clientes_vendidos_por_usuario(){

        $this->withoutExceptionHandling();
        $this->signIn();


        $cliente = factory(Cliente::class)->create();
        $usuario = factory(User::class)->create();




        $venta = factory(Venta::class)->create(
            [
                "id_cliente" => $cliente->id,
                "id_user" => $usuario->id
            ]
        );

        $productos_vendidos = factory(ProductoVendido::class,5)->create(["id_venta" => $venta->id]);


        $response = $this->get("/estadisticas");

        $response->assertSee($cliente->nombre);
        $response->assertSee($usuario->name);
     
        $response->assertSee(5);

        $response->assertStatus(200);
    }
    
}
