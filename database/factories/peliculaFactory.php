<?php

use Faker\Generator as Faker;
use App\Models\Genero;
use App\Models\Calificacion_edades;
use App\Models\CalificacionEdad;

$factory->define(App\Models\Pelicula::class, function (Faker $faker) {
    
    $generos = Genero::all();
    $calificaciones_edades = CalificacionEdad::all();

    return [
        'titulo' => $faker->name,
        'director' => $faker->name,
        'sinopsis' => $faker->text(150),
        'duracion' => $faker->time($format = 'H:i:s', $max = 'now'),
        'actores' => $faker->name,
        'cartel' => $faker->domainName,
        'genero_id' => $generos[rand(0,(sizeof($generos)-1))],
        'calificacion_edad_id' => $calificaciones_edades[rand(0,(sizeof($calificaciones_edades)-1))],
    ];
});
