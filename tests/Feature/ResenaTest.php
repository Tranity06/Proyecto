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
    protected $pelicula;
    protected $resena;

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

        $this->resena = Resena::create([
            'valoracion' => 3,
            'comentario' => 'Chuli',
            'pelicula_id' => $this->pelicula->id,
            'user_id' => $this->user->id
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

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
            'Authorization' => 'Bearer '.$token];


        $this->get(route('resena.get'),$headers)
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
    public function crear_resena_usuario_logueado()
    {
        $resena = [
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'pelicula_id' => 4
        ];

        $credentials = [
            'email' => $this->user->email,
            'password' => '123456'
        ];
        $this->post('/api/login', $credentials);
        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('resena.crearResenia'), $resena, $headers)
             ->assertStatus(201)
             ->assertJsonFragment(['comentario' => 'Chachi']);
    }

    /** @test */
    public function crear_resena_usuario_no_logueado()
    {
        $resena = [
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'pelicula_id' => $this->pelicula->id
        ];

        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->post(route('resena.crearResenia'), $resena, $headers)
             ->assertStatus(403)
             ->assertSee('Debes autenticarte para poder comentar.');
    } 

    /** @test */
    public function crear_resena_con_usuario_logueado_pelicula_repetida()
    {
        Resena::create([
            'valoracion' => 3,
            'comentario' => 'Chuli',
            'pelicula_id' => $this->pelicula->id,
            'user_id' => $this->user->id
        ]);
        $resena = [
            'valoracion' => 2,
            'comentario' => 'Chachi',
            'pelicula_id' => $this->pelicula->id
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('resena.crearResenia'), $resena, $headers)
             ->assertStatus(403)
             ->assertSee('¡Ya has comentado sobre esta película! Puedes editar tu reseña desde tu perfil.');
    }

    /** @test */
    public function crear_resena_con_usuario_logueado_sin_valoración()
    {
        $resena = [
            'valoracion' => '',
            'comentario' => 'Chachi',
            'pelicula_id' => 4
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('resena.crearResenia'), $resena, $headers)
             ->assertStatus(403)
             ->assertSee('Debes rellenar todos los campos.');
    }

    /** @test */
    public function crear_resena_con_usuario_logueado_sin_comentario()
    {
        $resena = [
            'valoracion' => 1,
            'comentario' => '',
            'pelicula_id' => 8
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('resena.crearResenia'), $resena, $headers)
             ->assertStatus(403)
             ->assertSee('Debes rellenar todos los campos.');
    }

    /** @test */
    public function crear_resena_con_usuario_logueado_sin_pelicula()
    {
        $resena = [
            'valoracion' => 1,
            'comentario' => 'Chu chu chuli',
            'pelicula_id' => ''
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('resena.crearResenia'), $resena, $headers)
             ->assertStatus(403)
             ->assertSee('Debes rellenar todos los campos.');
    }

    /**********************************************************
     *          RUTA - PUT '/resena/'
     **********************************************************/

    /** @test */
    public function update_resena_con_usuario_logueado()
    {
        $resena_modificada = [
            'valoracion' => 2,
            'comentario' => 'Nuevo'
        ];
        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('api/resena/'.$this->resena->id, $resena_modificada, $headers)
             ->assertStatus(201)
             ->assertJsonFragment(['comentario' => 'Nuevo']);
    }

    /** @test */
    public function update_resena_sin_usuario_logueado()
    {
        $resena_modificada = [
            'valoracion' => 2,
            'comentario' => 'Chachi',
        ];

        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->put('api/resena/'.$this->resena->id, $resena_modificada, $headers)
             ->assertStatus(403)
             ->assertSee('Debes autenticarte para poder comentar.');
    }

    /** @test */
    public function update_resena_con_usuario_logueado_resena_no_existe()
    {
        $resena_modificada = [
            'valoracion' => 2,
            'comentario' => 'Nuevo'
        ];
        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('api/resena/222'.$this->resena->id, $resena_modificada, $headers)
             ->assertStatus(400)
             ->assertSee('no existe.');
    }

    /** @test */
    public function update_resena_con_usuario_logueado_sin_valoración()
    {
        $resena_modificada = [
            'valoracion' => '',
            'comentario' => 'Chachi',
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('api/resena/'.$this->resena->id, $resena_modificada, $headers)
             ->assertStatus(403)
             ->assertSee('Debes rellenar todos los campos.');
    }

    /** @test */
    public function update_resena_con_usuario_logueado_sin_comentario()
    {
        $resena_modificada = [
            'valoracion' => '2',
            'comentario' => '',
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('api/resena/'.$this->resena->id, $resena_modificada, $headers)
             ->assertStatus(403)
             ->assertSee('Debes rellenar todos los campos.');
    }

    /** @test */
    public function update_resena_otro_usuario()
    {
        $resena_ajena = Resena::create([
            'valoracion' => 3,
            'comentario' => 'Chuli',
            'pelicula_id' => $this->pelicula->id,
            'user_id' => 22
        ]);

        $resena_modificada = [
            'valoracion' => 3,
            'comentario' => 'Chachi'
        ];

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('api/resena/'.$resena_ajena->id, $resena_modificada, $headers)
             ->assertStatus(403)
             ->assertSee('Ops');
    }

    /**********************************************************
     *          RUTA - DELETE '/resena/'
     **********************************************************/

     /** @test */
    public function delete_resena_con_usuario_logueado()
    {
        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('api/resena/'.$this->resena->id, [], $headers)
             ->assertStatus(204);
    }

    /** @test */
    public function delete_resena_sin_usuario_logueado()
    {
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->delete('api/resena/'.$this->resena->id,[], $headers)
             ->assertStatus(403)
             ->assertSee('Debes autenticarte para poder comentar.');
    }

    /** @test */
    public function delete_resena_con_usuario_logueado_resena_no_existe()
    {
        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('api/resena/555',[], $headers)
             ->assertStatus(400)
             ->assertSee('no existe.');
    }

    /** @test */
    public function delete_resena_otro_usuario()
    {
        $resena_ajena = Resena::create([
            'valoracion' => 3,
            'comentario' => 'Chuli',
            'pelicula_id' => $this->pelicula->id,
            'user_id' => 22
        ]);

        $token = JWTAuth::fromUser($this->user);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('api/resena/'.$resena_ajena->id, [], $headers)
             ->assertStatus(403)
             ->assertSee('Ops');
    }
}