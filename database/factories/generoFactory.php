<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Genero::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->name,
    ];
});
