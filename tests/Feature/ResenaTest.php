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
     *          RUTA - '/resena/'
     **********************************************************/

    protected $user;
    protected $pelicula;

    public function setUp()
    {
        parent::setUp();

        $this->user = User::create([
            'id'=> 1,
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'telefono' => 654987321,
            'is_verified' => 1
        ]);

        $this->pelicula = Pelicula::create([
            'idtmdb' => 299536,
            'titulo' => $this->faker->name,
            'titulo_original' => $this->faker->name,
            'estreno' => $this->faker->date(),
            'generos' => 'Aventura, Ciencia ficción, Fantasía, Acción',
            'director' => $this->faker->name,
            'actores' => $this->faker->name,
            'sinopsis' => $this->faker->text,
            'duracion' => 149,
            'cartel' => $this->faker->name,
            'trailer' => 'https://www.youtube.com/watch?v=wJbudwIF0cE',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/bOGkgRGdhrBYJSLpXaxhXVstddV.jpg',
            'popularidad' => 604.520984
        ]);
    }

    /** @test */
    public function ver_resenas_usuario()
    {

        Resena::create([
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'user_id' => $this->user->id,
            'pelicula_id' => $this->pelicula->id
        ]);

        $this->actingAs($this->user, 'api')
             ->get(route('resena.get'))
             ->assertJsonStructure([
                '*' => [
                    'id', 'valoracion', 'comentario', 'user_id', 'pelicula_id'
                ]
            ])
            ->assertJsonFragment(['comentario' => 'Chachi'])
        ;
    }
}