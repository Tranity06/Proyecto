<?php

use Faker\Generator as Faker;
use App\Models\Producto;
use App\Models\Ingrediente;

$factory->define(App\Models\ProductoIngrediente::class, function (Faker $faker) {

    $productos = Producto::all();
    $ingredientes = Ingrediente::all();

    return [
        'producto_id' =>  $productos[rand(0,(sizeof($productos)-1))],
        'ingrediente_id' => $ingredientes[rand(0,(sizeof($ingredientes)-1))],
    ];
});
