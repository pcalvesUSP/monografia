<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Orientador;
use Faker\Generator as Faker;

$factory->define(Orientador::class, function (Faker $faker) {
    return [
         "id" => $faker->numberBetween(10000,999999)
        ,"nome" => $faker->name()
        ,"externo" => $faker->boolean()
    ];
});
