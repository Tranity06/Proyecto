<?php

use Illuminate\Database\Seeder;
use App\Models\Sesion;
use App\Models\Pelicula;
use App\Models\Sala;

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
        $horas = ['16:00:00', '18:00:00', '20:00:00', '22:00:00', '24:00:00'];

        foreach ( $horas as $hora ){
            $incremento = 0;
            foreach ( $salas as $sala ){
                $hora_sesion = date("H:i:s", strtotime($hora)+($incremento*60));
                $incremento+=5;
                for ( $i=0 ; $i<7; $i++ ){
                    Sesion::create([
                        'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d')+$i, date('Y'))),
                        'hora' => $hora_sesion,
                        'estado' => rand(0, 1),
                        'pelicula_id' => $peliculas[rand(0,(sizeof($peliculas)-1))]->id,
                        'sala_id' => $sala->id,
                    ]);
                }
            }
        }
    }
}
