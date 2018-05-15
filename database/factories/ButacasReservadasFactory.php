<?php

use Faker\Generator as Faker;
use App\Models\Sesion;
use App\Models\Butaca;
use App\Models\Factura;

$factory->define(App\Models\ButacaReservada::class, function (Faker $faker) {

    $sesiones = Sesion::all();
    $butacas = Butaca::all();
    $facturas = Factura::all();

    return [
        'estado' => rand(0, 2),
        'sesion_id' => $sesiones[rand(0,(sizeof($sesiones)-1))],
        'butaca_id' => $butacas[rand(0,(sizeof($butacas)-1))],
        'factura_id' => $facturas[rand(0,(sizeof($facturas)-1))],
    ];
});
