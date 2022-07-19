<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Unitermo;

$factory->define(Unitermo::class, function (Faker $faker) {
    return [
        'unitermo' => $faker->word()
    ];
});
