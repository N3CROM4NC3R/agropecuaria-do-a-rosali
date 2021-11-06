<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        "nombre" => $faker->firstName,
        "apellido" => $faker->lastName,
        "email" => $faker->email,
        "cedula" => $faker->nationalId,
        "direccion" => $faker->address,
        "telefono" => $faker->phoneNumber
    ];
});
