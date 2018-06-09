<?php

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Bebidas'
        ]);

        Categoria::create([
            'nombre' => 'Patatas y derivados'
        ]);

        Categoria::create([
            'nombre' => 'Comida caliente'
        ]);

        Categoria::create([
            'nombre' => 'Chocolates y lácteos'
        ]);

        Categoria::create([
            'nombre' => 'Todos'
        ]);
    }
}
