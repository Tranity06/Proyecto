<?php

use Illuminate\Database\Seeder;
use App\Models\Sala;
use App\Models\Pelicula;
use App\Models\Sesion;
use App\Models\Butaca;

class TestSalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Salas
        for ( $i=1 ; $i<3 ; $i++ ){
            Sala::create([
                'numero' => $i
            ]);
        }

        //Butacas
        $salas = Sala::get();
        foreach ($salas as $sala ){
            for ($fila = 1 ; $fila < 4 ; $fila++){
                for($butaca=1 ; $butaca<6 ; $butaca++){
                    Butaca::create([
                        'fila' => $fila,
                        'numero' => $butaca,
                        'estado' => rand(0, 1),
                        'sala_id' => $sala->id
                    ]);
                }
            }
        }

        //Pelicula
        Pelicula::create([
            'idtmdb' => 299536,
            'titulo' => 'Vengadores: Infinity War',
            'titulo_original' => 'Avengers: Infinity War',
            'estreno' => '2018-04-25',
            'generos' => 'Aventura, Ciencia ficción, Fantasía, Acción',
            'director' => 'Joe Russo, Anthony Russo',
            'actores' => 'Robert Downey Jr., Chris Hemsworth, Mark Ruffalo, Chris Evans, Scarlett Johansson',
            'sinopsis' => 'Vengadores: Infinity War seguirá la lucha de los superhéroes de Marvel contra el mayor villano al que se han enfrentado nunca: Thanos. Su único objetivo será detener a este poderoso antagonista e impedir que se haga con el control de la galaxia. De nuevo veremos al grupo formado por Iron Man, Capitán América, Viuda negra, Ant-Man, Ojo de Halcón, Thor y Hulk, entre otros. En su nueva e impactante aventura, las Gemas del Infinito estarán en juego, unos querrán protegerlas y otros controlarlas, ¿quién ganará?',
            'duracion' => 149,
            'cartel' => 'https://image.tmdb.org/t/p/w342/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=wJbudwIF0cE',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/bOGkgRGdhrBYJSLpXaxhXVstddV.jpg',
            'popularidad' => 604.520984
        ]);

        //Sesion
        $sala = Sala::first();
        $pelicula = Pelicula::first();
        Sesion::create([
            'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d'), date('Y'))),
            'hora' => '16:00:00',
            'estado' => 1,
            'pelicula_id' => $pelicula->id,
            'sala_id' => $sala->id,
            'pase' => 1
        ]);
    }
}
