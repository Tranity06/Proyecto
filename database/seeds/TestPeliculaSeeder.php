<?php

use Illuminate\Database\Seeder;
use App\Models\Sala;
use App\Models\Pelicula;
use App\Models\Sesion;
use App\Models\Resena;
use App\Models\User;

class TestPeliculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Salas
        for ( $i=1; $i<=3 ; $i++){
            Sala::create([
                'numero' => $i
            ]);
        }

        //Peliculas
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

        Pelicula::create([
            'idtmdb' => 284053,
            'titulo' => 'Thor: Ragnarok',
            'titulo_original' => 'Thor: Ragnarok',
            'estreno' => '2017-10-25',
            'generos' => 'Acción, Aventura, Fantasía',
            'director' => 'Taika Waititi',
            'actores' => 'Chris Hemsworth, Tom Hiddleston, Cate Blanchett, Mark Ruffalo, Tessa Thompson',
            'sinopsis' => 'Thor está preso al otro lado del universo sin su poderoso martillo y se enfrenta a una carrera contra el tiempo. Su objetivo es volver a Asgard y parar el Ragnarok porque significaría la destrucción de su planeta natal y el fin de la civilización Asgardiana a manos de una todopoderosa y nueva amenaza, la implacable Hela. Pero, primero deberá sobrevivir a una competición letal de gladiadores que lo enfrentará a su aliado y compañero en los Vengadores, ¡el Increíble Hulk!',
            'duracion' => 130,
            'cartel' => 'https://image.tmdb.org/t/p/w342/s7hV8HFh7w2EZ4GK5EiltRVvWJA.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=rwPvpkfozCE',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/kaIfm5ryEOwYg8mLbq8HkPuM1Fo.jpg',
            'popularidad' => 174.148284
        ]);

        Pelicula::create([
            'idtmdb' => 353486,
            'titulo' => 'Jumanji: Bienvenidos a la jungla',
            'titulo_original' => 'Jumanji: Welcome to the Jungle',
            'estreno' => '2017-12-09',
            'generos' => 'Acción, Aventura, Comedia, Familia',
            'director' => 'Jake Kasdan',
            'actores' => 'Dwayne Johnson, Jack Black, Kevin Hart, Karen Gillan, Nick Jonas',
            'sinopsis' => 'Cuatro adolescentes son absorbidos por un videojuego, en el que se convierten en avatares de personajes arquetípicos. Allí vivirán múltiples aventuras, al tiempo que buscan cómo salir de allí para volver a su mundo.',
            'duracion' => 119,
            'cartel' => 'https://image.tmdb.org/t/p/w342/thmLO2GWf6NcuNOoYtv2gOomE4x.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=leIrosWRbYQ',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/rz3TAyd5kmiJmozp3GUbYeB5Kep.jpg',
            'popularidad' => 54.184919
        ]);

        //Sesiones
        $peliculas = Pelicula::all();
        $salas = Sala::all();
        $horas = ['16:00:00', '18:00:00', '20:00:00', '22:00:00', '24:00:00'];

        foreach ( $horas as $hora ){
            $incremento = 0;
            foreach ( $salas as $sala ){
                $hora_sesion = date("H:i:s", strtotime($hora)+($incremento*60));
                $incremento+=5;
                for ( $i=0 ; $i<3; $i++ ){
                    Sesion::create([
                        'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d')+$i, date('Y'))),
                        'hora' => $hora_sesion,
                        'estado' => rand(0, 1),
                        'pelicula_id' => $peliculas[rand(0,(sizeof($peliculas)-1))]->id,
                        'sala_id' => $sala->id,
                        'pase' => rand(1, 4),
                    ]);
                }
            }
        }

        //Usuario
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'telefono' => 654987321,
            'is_verified' => 1
        ]);

        //Reseñas
        $peliculaId = Pelicula::get()->first()->id;
        $userId = User::get()->first()->id;
        Resena::create([
            'valoracion' => 1,
            'comentario' => 'abc',
            'user_id' => $userId,
            'pelicula_id' => $peliculaId
        ]);
    }
}
