<?php

use Illuminate\Database\Seeder;
use App\Models\Ingrediente;

class IngredientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ingrediente::create([
            'nombre' => 'Sal',
            'descripcion' => 'Usado para darle más sabor a las comidas'
        ]);

        Ingrediente::create([
            'nombre' => 'Harina',
            'descripcion' => 'Usado para rebozados'
        ]);

        Ingrediente::create([
            'nombre' => 'Agua',
            'descripcion' => 'Ingrediente básico'
        ]);

        Ingrediente::create([
            'nombre' => 'Azúcar',
            'descripcion' => 'Usado para endulzar algunos alimentos'
        ]);

        Ingrediente::create([
            'nombre' => 'Glúten',
            'descripcion' => 'Tipo de sustancia existente en algunos productos (es un alérgeno)'
        ]);

        Ingrediente::create([
            'nombre' => 'Huevos',
            'descripcion' => 'Rico en proteínas'
        ]);
/*
        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);

        Ingrediente::create([
            'nombre' => '',
            'descripcion' => ''
        ]);*/
    }
}
