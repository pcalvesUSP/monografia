<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Monografia;
use Faker\Generator as Faker;

$factory->define(Monografia::class, function (Faker $faker) {
    return [
        "titulo" => $faker->text(100)
       ,"resumo" => $faker->sentence(500,true)
       ,"template_apres" => $faker->url()
       ,"ano" => $faker->year()
       ,"unitermo1" => $faker->numberBetween(1,50)
       ,"unitermo2" => $faker->numberBetween(1,50)
       ,"unitermo3" => $faker->numberBetween(1,50)
    ];
});
