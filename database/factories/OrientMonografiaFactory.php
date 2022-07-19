<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Monografia;
use App\Orientador;
use App\OrientMonografia;
use Faker\Generator as Faker;

$factory->define(OrientMonografia::class, function (Faker $faker) {

    $monografiaValidator = function($number) {
        return Monografia::where('id','=', $number)->count();
    };
    
    $orientValidator = function($number) {
        return Orientador::where('id','=', $number)->count();
    };

    return [
        "orientador_id" => $faker->valid($orientValidator)->numberBetween(10000,999999)
       ,"monografia_id" => $faker->numberBetween(1,50)
    ];
});
