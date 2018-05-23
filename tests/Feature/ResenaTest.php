<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Resena;
use App\Models\Pelicula;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class ResenaTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    //protected $token;
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

       /*  $this->token = JWTAuth::fromUser($this->user);
        JWTAuth::setToken($this->token);
        Auth::attempt(['name' => $this->user->name, 'password' => $this->user->password]); */

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

    /**********************************************************
     *          RUTA - GET '/resena/'
     **********************************************************/

    /** @test */
    public function ver_resenas_usuario_logueado()
    {

        Resena::create([
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'user_id' => $this->user->id,
            'pelicula_id' => $this->pelicula->id
        ]);

        $this->actingAs($this->user, 'api')
             ->get(route('resena.get'))
             ->assertStatus(201)
             ->assertJsonStructure([
                '*' => [
                    'id', 'valoracion', 'comentario', 'user_id', 'pelicula_id'
                ]
            ])
            ->assertJsonFragment(['comentario' => 'Chachi']);
    }

    /** @test */
    public function ver_resenas_usuario_no_logueado()
    {
        Resena::create([
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'user_id' => $this->user->id,
            'pelicula_id' => $this->pelicula->id
        ]);

        $this->get(route('resena.get'))
             ->assertStatus(403);
    }

    /**********************************************************
     *          RUTA - POST '/resena/'
     **********************************************************/

     /** @test */
   /*  public function crear_resena_usuario_logueado()
    {
        $resena = [
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'pelicula_id' => $this->pelicula->id
        ];

        $token = JWTAuth::fromUser($this->user);
        JWTAuth::setToken($token);
        Auth::attempt(['name' => $this->user->name, 'password' => $this->user->password]);

        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token ];
        $this->actingAs($this->user, 'api')
             ->post(route('resena.crearResenia'), $resena, $headers) //Añadir token a la ruta
             ->assertStatus(201)
             ->assertJsonStructure([
                '*' => [
                    "valoracion","comentario","user_id","pelicula_id","updated_at",
                    "created_at","id","imagen_usuario","nombre_usuario"
                ]
            ])
            ->assertJsonFragment(['comentario' => 'Chachi']);
    } */
}