<?php

use Faker\Generator as Faker;
use App\Models\Categoria;

$factory->define(App\Models\Producto::class, function (Faker $faker) {

    $categorias = Categoria::all();

    return [
        'nombre' =>  $faker->unique()->name,
        'precio' => $faker->randomFloat($nbMaxDecimals = 2, $min = 2, $max = 5),
        'stock' => rand(0, 1000),
        'imagen' => $faker->domainName,
        'categoria_id' =>  $categorias[rand(0,(sizeof($categorias)-1))],
    ];
});
