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
        factory(Ingrediente::class,30)->create();
    }
}
