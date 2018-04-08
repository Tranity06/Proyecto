<?php

use Faker\Generator as Faker;
use App\Models\Pelicula;
use App\Models\Sala;

$factory->define(App\Models\Sesion::class, function (Faker $faker) {

    $peliculas = Pelicula::all();
    $salas = Sala::all();

    return [
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'hora' => $faker->time($format = 'H:i:s', $max = 'now'),
        'estado' => rand(0, 1),
        'pelicula_id' => $peliculas[rand(0,(sizeof($peliculas)-1))],
        'sala_id' => $salas[rand(0,(sizeof($salas)-1))],
    ];
});
