<?php

use Faker\Generator as Faker;
use App\Models\Producto;
use App\Models\Factura;

$factory->define(App\Models\LineaVenta::class, function (Faker $faker) {

    $productos = Producto::all();
    $facturas = Factura::all();

    return [
        'cantidad' => rand(1,5),
        'producto_id' => $productos[rand(0,(sizeof($productos)-1))],
        'factura_id' => $facturas[rand(0,(sizeof($facturas)-1))],
    ];
});
