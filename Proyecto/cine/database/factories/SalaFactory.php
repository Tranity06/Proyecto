<?php

use Faker\Generator as Faker;
$factory->define(App\Models\Sala::class, function (Faker $faker) {

    return [
        'numero' => $faker->unique()->randomDigit,
    ];
});