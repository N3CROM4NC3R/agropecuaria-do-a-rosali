<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductoVendido;
use Faker\Generator as Faker;

$factory->define(ProductoVendido::class, function (Faker $faker) {
    return [
        "descripcion"   => $faker->name,
        "codigo_barras" => $faker->ean13,
        "precio" => $faker->randomFloat(2, 0, 100),
        "cantidad" => $faker->randomNumber(2)
    ];
});
