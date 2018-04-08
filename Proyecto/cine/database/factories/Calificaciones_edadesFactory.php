<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Calificacion_edades::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->name,
        'icono' => $faker->unique()->domainName,
    ];
});
