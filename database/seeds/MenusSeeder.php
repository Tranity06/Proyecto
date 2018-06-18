<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        Menu::create([
            'nombre' => 'Menú 1'
        ]);

        Menu::create([
            'nombre' => 'Menú 2'
        ]);

        Menu::create([
            'nombre' => 'Menú 3'
        ]);

        Menu::create([
            'nombre' => 'Menú 4'
        ]);
=======
        for ( $i=1 ; $i<5 ; $i++ ){
            Menu::create([
                'nombre' => 'Menú '.$i
            ]);
        }
>>>>>>> desarrollo
    }
}
