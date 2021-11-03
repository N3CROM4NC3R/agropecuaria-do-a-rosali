<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) {
    return [
        "codigo_barras" => $faker->ean13,
        "descripcion" => $faker->name,
        "precio_venta" => $faker->randomNumber(2)
    ];
});
