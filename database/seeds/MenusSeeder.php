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
        for ( $i=1 ; $i<5 ; $i++ ){
            Menu::create([
                'nombre' => 'Menú '.$i
            ]);
        }
    }
}
