<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductoVendido;
use App\Venta;
use Faker\Generator as Faker;

$factory->define(ProductoVendido::class, function (Faker $faker) {
    $venta = factory(Venta::class)->create();
    
    
    return [
        "descripcion"   => $faker->name,
        "codigo_barras" => $faker->ean13,
        "precio" => $faker->randomFloat(2, 0, 100),
        "cantidad" => $faker->randomNumber(2),
        "id_venta" => $venta->id
    ];
});
