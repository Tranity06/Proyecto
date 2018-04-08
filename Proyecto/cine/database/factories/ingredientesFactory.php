<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Ingrediente::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->name,
        'descripcion' => $faker->text(150),
    ];
});
