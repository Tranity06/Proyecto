<?php

use Illuminate\Database\Seeder;
use App\Models\PlantillaSesion;

class TestPlantillaSeeder extends Seeder
{
    /**
     * Run the database seeds .
     *
     * @return void
     */
    public function run()
    {
        PlantillaSesion::create([
            'nombre' => 'laboral',
            'descripcion' => 'Para los dias laborales'
        ]);

        PlantillaSesion::create([
            'nombre' => 'finde',
            'descripcion' => 'Para los fines de semana'
        ]);
    }
}
