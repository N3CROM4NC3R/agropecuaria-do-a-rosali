<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venta;
use Faker\Generator as Faker;

use App\Cliente;
use App\User;

$factory->define(Venta::class, function (Faker $faker) {
    
    $precio_bruto = $faker->randomFloat(2, 0, 100);
    $taza = $faker->randomFloat(2, 0, 0.5);

    $iva = $taza * $precio_bruto;

    $precio_neto = $precio_bruto + $iva;
    
    $cliente = factory(Cliente::class)->create();
    $vendedor = factory(User::class)->create();
    

    
    return [
        "precio_bruto" => $precio_bruto,
        "precio_neto" => $precio_neto,
        "iva" => $iva,
        "id_cliente" => $cliente->id,
        "id_user" => $vendedor->id
    ];
});
