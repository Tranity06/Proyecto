<?php

use Illuminate\Database\Seeder;
use App\Models\Sesion;
use App\Models\Pelicula;
use App\Models\Sala;
use App\Models\Butaca;
use App\Models\ButacaReservada;

class SesionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $peliculas = Pelicula::all();
        $salas = Sala::all();
        $horas = ['16:00:00', '18:00:00', '20:00:00', '22:00:00'];

        for ( $dia=0 ; $dia<1; $dia++ ){
            $incremento = 0;
            foreach ( $salas as $sala ){
                $pase = 0;
                $incremento+=5;
                foreach ( $horas as $hora ){
                    $pase++;
                    $hora_sesion = date("H:i:s", strtotime($hora)+($incremento*60));
                    $sesion_registrada = Sesion::create([
                        'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d')+$dia, date('Y'))),
                        'hora' => $hora_sesion,
                        'estado' => 1,
                        'pelicula_id' => $peliculas[rand(0,(sizeof($peliculas)-1))]->id,
                        'sala_id' => $sala->id,
                        'pase' => $pase
                    ]);

                    $butacas_reservadas = Butaca::where('sala_id', $sala->id)->get();
                    foreach($butacas_reservadas as $butaca_reservada){
                        ButacaReservada::create([
                            'estado' => $butaca_reservada->estado,
                            'sesion_id' => $sesion_registrada->id,
                            'butaca_id' => $butaca_reservada->id,
                        ]);
                    }
                }
            }
        }



        /* foreach ( $horas as $hora ){
            $pase=0;
            $incremento = 0;
            foreach ( $salas as $sala ){
                $pase++;
                $hora_sesion = date("H:i:s", strtotime($hora)+($incremento*60));
                $incremento+=5;
                for ( $dia=0 ; $dia<7; $dia++ ){
                    $sesion_registrada = Sesion::create([
                        'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d')+$dia, date('Y'))),
                        'hora' => $hora_sesion,
                        'estado' => rand(0, 1),
                        'pelicula_id' => $peliculas[rand(0,(sizeof($peliculas)-1))]->id,
                        'sala_id' => $sala->id,
                        'pase' => $pase
                    ]);

                    $butacas_reservadas = Butaca::where('sala_id', $sala->id)->get();
                    foreach($butacas_reservadas as $butaca_reservada){
                        ButacaReservada::create([
                            'estado' => $butaca_reservada->estado,
                            'sesion_id' => $sesion_registrada->id,
                            'butaca_id' => $butaca_reservada->id,
                        ]);
                    }
                }
            }
        } */
    }
}
