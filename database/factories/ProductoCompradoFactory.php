<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductoComprado;
use Faker\Generator as Faker;

use App\Proveedor;
use App\Producto;

$factory->define(ProductoComprado::class, function (Faker $faker) {
    
    $proveedor = factory(Proveedor::class)->create();
    $producto = factory(Producto::class)->create();

    
    return [
        "precio_unidad" => $faker->randomFloat(2, 0, 100),
        "cantidad" => $faker->randomNumber(2),
        "id_proveedor" => $proveedor->id,
        "id_producto" => $producto->id,
    ];
});
