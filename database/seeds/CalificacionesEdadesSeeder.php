<?php

use Illuminate\Database\Seeder;
use App\Models\Calificacion_edades;
use App\Models\CalificacionEdad;

class CalificacionesEdadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CalificacionEdad::class,5)->create();
    }
}
