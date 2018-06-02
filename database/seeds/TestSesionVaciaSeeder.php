<?php

use Illuminate\Database\Seeder;
use App\Models\SesionVacia;
use App\Models\Sala;

class TestSesionVaciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sala = Sala::create([
            'numero' => 1,
        ]);

        SesionVacia::create([
            'pase' => 1,
            'hora' => '16:00:00',
            'sala_id' => $sala->id
        ]);
    }
}
