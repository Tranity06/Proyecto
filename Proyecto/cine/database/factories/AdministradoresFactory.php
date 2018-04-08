<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Administrador::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
    ];
});
