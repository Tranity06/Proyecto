<?php

use Faker\Generator as Faker;
use App\Models\Usuario;

$factory->define(App\Models\Factura::class, function (Faker $faker) {

    $usuarios = Usuario::all();

    return [
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'usuario_id' => $usuarios[rand(0,(sizeof($usuarios)-1))],
    ];
});
