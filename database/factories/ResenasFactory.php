<?php

use Faker\Generator as Faker;
use App\Models\Usuario;
use App\Models\Pelicula;

$factory->define(App\Models\Resena::class, function (Faker $faker) {

    $usuarios = Usuario::all();
    $peliculas = Pelicula::all();

    return [
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'valoracion' => $faker->numberBetween(0,5),
        'comentario' => $faker->text(150),
        'usuario_id' => $usuarios[rand(0,(sizeof($usuarios)-1))],
        'pelicula_id' => $peliculas[rand(0,(sizeof($peliculas)-1))],
    ];
});
