<?php

use App\Models\Sala;
use Faker\Generator as Faker;

$factory->define(App\Models\Butaca::class, function (Faker $faker) {

    $salas = Sala::all();
    static $number = 1;

    return [
        'fila' => 1,
        'numero' => $number++,
        'estado' => $faker->numberBetween(0,3),
        'sala_id' => $salas[rand(0,(sizeof($salas)-1))],
    ];
});
