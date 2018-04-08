<?php

use Illuminate\Database\Seeder;
use App\Models\Calificacion_edades;

class CalificacionesEdadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Calificacion_edades::class,5)->create();
    }
}
