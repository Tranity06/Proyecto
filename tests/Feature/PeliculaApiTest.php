<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Artisan;
use App\Models\Pelicula;

class PeliculaApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->seed('TestPeliculaSeeder');
    }

    /** @test */
    public function ver_peliculas_y_sesiones_programadas(){
        $this->get(route('pelicula.getAll'))
            ->assertStatus(200)
            ->assertJsonMissing([
                'estado' => 0
            ]);
    }

    /** @test */
    public function ver_info_y_resenas_pelicula(){
        $idPelicula = Pelicula::get()->first()->id;
        $this->get('api/pelicula/'.$idPelicula)
            ->assertStatus(200)
            ->assertJsonMissing([
                'estado' => 0
            ])
            ->assertJsonFragment([
                'id' => $idPelicula
            ]);
    }

    /** @test */
    public function ver_resenas_pelicula(){
        $idPelicula = (string)(Pelicula::get()->first()->id);
        $this->get('api/pelicula/'.$idPelicula.'/resenas')
            ->assertStatus(200)
            ->assertJsonFragment([
                'pelicula_id' => $idPelicula
            ]);
    }
}
