<?php

use Faker\Generator as Faker;
use App\Models\Menu;
use App\Models\Producto;

$factory->define(App\Models\ProductoMenu::class, function (Faker $faker) {
    
    $productos = Producto::all();
    $menus = Menu::all();

    return [
        'producto_id' =>  $productos[rand(0,(sizeof($productos)-1))],
        'menu_id' => $menus[rand(0,(sizeof($menus)-1))],
    ];
});
