<?php

use App\Models\Butaca;
use Illuminate\Database\Seeder;
use App\Models\Sala;

class ButacaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salas = Sala::all();

        foreach ($salas as $sala){
            for ( $fila=1 ; $fila<=8 ; $fila++ ){
                for ( $butaca=1 ; $butaca<=8 ; $butaca++ ){
                    Butaca::create([
                        'fila' => $fila,
                        'numero' => $butaca,
                        'estado' => rand(0, 1),
                        'sala_id' => $sala->id,
                    ]);
                }
            }
        }
    }
}
