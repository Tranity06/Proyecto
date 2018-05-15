<?php

use Illuminate\Database\Seeder;
use App\Models\ProductoMenu;

class ProductosMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProductoMenu::class,80)->create();
    }
}
