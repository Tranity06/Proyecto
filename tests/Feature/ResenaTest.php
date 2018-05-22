<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Resena;
use App\Models\Pelicula;

class ResenaTest extends TestCase
{
    use RefreshDatabase;
    /**********************************************************
     *          RUTA - '/resena/{idUsuario}'
     **********************************************************/
    /** @test */
    public function ver_resenas_usuario()
    {
        $user = User::create([
            'id'=> 1,
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'telefono' => 654987321,
            'is_verified' => 1
        ]);
        $pelicula = Pelicula::create([
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
        $resena = Resena::create([
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'user_id' => $user->id,
            'pelicula_id' => $pelicula->id
        ]);
        $this->actingAs($user, 'api')
             ->get('/resena/1')
             ->seeJsonStructure([
                '*' => [
                    'id', 'valoracion', 'comentario', 'user_id', 'pelicula_id'
                ]
            ])
             ->seeJsonEquals([
                'valoracion' => 2,
                'comentario' => 'Chachi',
            ]);;
    }
}
