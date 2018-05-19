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
        $fechas = ['2018/05/01', '2018/05/02', '2018/05/03', '2018/05/04', '2018/05/05', '2018/05/06', '2018/05/07'];
        $incremento = 0;

        foreach ( $horas as $hora ){
            foreach ( $salas as $sala ){
                $hora_sesion = date("H:i:s", strtotime($hora)+($incremento*60));
                $incremento+=5;
                foreach ( $fechas as $fecha ){
                    Sesion::create([
                        'fecha' => $fecha,
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
