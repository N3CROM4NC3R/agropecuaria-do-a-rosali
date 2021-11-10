<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Proveedor;
use Faker\Generator as Faker;

$factory->define(Proveedor::class, function (Faker $faker) {
    return [
        "nombre" => $faker->firstName,
        "apellido" => $faker->lastName,
        "cedula" => $faker->nationalId,
        "direccion" => $faker->address,
        "telefono" => $faker->phoneNumber
    ];
});
