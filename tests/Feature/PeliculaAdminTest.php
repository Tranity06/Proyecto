<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Administrador;
use App\Models\Pelicula;

class PeliculaAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $pelicula;

    public function setUp()
    {
        parent::setUp();
        
        $this->admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
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

    /**********************************************************
     *          RUTA - GET pelicula/crear
     **********************************************************/
    /** @test */
    public function crear_pelicula_sin_admin() {
        $this->get('pelicula/crear')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function crear_pelicula_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('/pelicula/crear')
            ->assertStatus(200)
            ->assertSee('Registrar nueva película')
            ->assertSee($this->admin->name);
    }

    /**********************************************************
     *          RUTA - POST pelicula/crear
     **********************************************************/

    /** @test */
    public function post_crear_pelicula_sin_admin() {
        $this->post('pelicula/crear')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function post_crear_pelicula_con_admin() {
        $pelicula = [
            'idtmdb' => 299599,
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
            'slider' => true,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/bOGkgRGdhrBYJSLpXaxhXVstddV.jpg',
            'popularidad' => 604.520984
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('/pelicula/crear', $pelicula, $headers)
            ->assertStatus(200)
            ->assertSee('Registrar nueva película')
            ->assertSee($this->admin->name)
            ->assertSee('Pelicula nueva registrada.');
    }

    /** @test */
    public function crear_pelicula_repetida() {
        $pelicula = [
            'idtmdb' => 299536
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('/pelicula/crear', $pelicula, $headers)
            ->assertStatus(200)
            ->assertSee('Registrar nueva película')
            ->assertSee($this->admin->name)
            ->assertSee('La película ya estaba registrada en la base de datos.');
    }

    /** @test */
    public function crear_película_campo_inválido() {
        $pelicula = [
            'idtmdb' => 'aaa',
            'titulo' => '',
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
        ];
        $this->actingAs($this->admin, 'admin')
            ->post('/pelicula/crear')
            ->assertStatus(403)
            ->assertSee('Debes rellenar todos los campos.');
    }

    /**********************************************************
     *          RUTA - GET peliculas/mostrar
     **********************************************************/
    /** @test */
    public function mostrar_peliculas_sin_admin() {
        $this->get('peliculas/mostrar')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function mostrar_peliculas_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('peliculas/mostrar')
            ->assertStatus(200)
            ->assertSee($this->admin->nombre)
            ->assertSee($this->pelicula->titulo);
    }

    /**********************************************************
     *          RUTA - POST peliculas/borrar
     **********************************************************/
    /** @test */
    public function borrar_pelicula_sin_admin() {
        $this->post('peliculas/borrar')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_pelicula_con_admin() {
        $idPelicula = ['id' => $this->pelicula->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('peliculas/borrar', $idPelicula, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_pelicula_no_registrada() {
        $idPelicula = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('peliculas/borrar', $idPelicula, $headers)
            ->assertStatus(400);
    }
}
