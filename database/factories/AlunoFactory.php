<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Aluno;
use App\Monografia;
use Faker\Generator as Faker;

$factory->define(Aluno::class, function (Faker $faker) {
    $evenValidator = function($number) {
        return Monografia::where('id','=', $number)->count();
    };

    return [
        "id" => $faker->numberBetween(10000,999999)
       ,"nome" => $faker->name()
       ,"monografia_id" => $faker->valid($evenValidator)->randomNumber() 
    ];
});
