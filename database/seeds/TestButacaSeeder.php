<?php

use Illuminate\Database\Seeder;
use App\Models\Sala;
use App\Models\Butaca;

class TestButacaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sala = Sala::create([
            'numero' => 1
        ]);

        for ( $fila=1 ; $fila<=3 ; $fila++ ){
            for ( $butaca=1 ; $butaca<=5 ; $butaca++ ){
                Butaca::create([
                    'fila' => $fila,
                    'numero' => $butaca,
                    'estado' => $fila==1? 1 : 0,
                    'sala_id' => $sala->id,
                ]);
            }
        }
    }
}
