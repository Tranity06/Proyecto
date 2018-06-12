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
        ProductoMenu::create([
            'producto_id' => '1',
            'menu_id' => '1'
        ]);

        ProductoMenu::create([
            'producto_id' => '2',
            'menu_id' => '1'
        ]);

        ProductoMenu::create([
            'producto_id' => '3',
            'menu_id' => '1'
        ]);
    }
}
