<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Configuracion;
use Faker\Generator as Faker;

$factory->define(Configuracion::class, function (Faker $faker) {
    
    
    return [
        "nombre" => $faker->name,
        "valor" => $faker->randomNumber(2)
    ];
});
