<?php

use Illuminate\Database\Seeder;
use App\Models\ProductoIngrediente;

class ProductosIngredientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProductoIngrediente::class,80)->create();
    }
}
