<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Administrador;
use Artisan;
use App\Models\SesionVacia;
use App\Models\Sala;

class SesionVaciaTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        
        $this->admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);

        Artisan::call('migrate');
        $this->seed('TestSesionVaciaSeeder');
    }

    /**********************************************************
     *          RUTA - POST sesionvacia/borrar (AJAX)
     **********************************************************/
    /** @test */
    public function borrar_sesionvacia_admin(){
        $sesion = [
            'idSesion' => SesionVacia::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->actingAs($this->admin, 'admin')
            ->post('sesionvacia/borrar', $sesion, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_sesionvacia_no_admin(){
        $sesion = [
            'idSesion' => SesionVacia::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->post('sesionvacia/borrar', $sesion, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_sesionvacia_no_registrada(){
        $sesion = [
            'idSesion' => 20
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->actingAs($this->admin, 'admin')
            ->post('sesionvacia/borrar', $sesion, $headers)
            ->assertStatus(403)
            ->assertSee('no existe.');
    }

    /**********************************************************
     *          RUTA - POST sesionvacia/crear (AJAX)
     **********************************************************/
    /** @test */
    public function crear_sesionvacia_admin(){
        $sesion = [
            'pase' => 1,
            'hora' => '18:00:00',
            'idSala' => Sala::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->actingAs($this->admin, 'admin')
            ->post('sesionvacia/crear', $sesion, $headers)
            ->assertStatus(201)
            ->assertSee('18:00:00');
    }

    /** @test */
    public function crear_sesionvacia_no_admin(){
        $sesion = [
            'pase' => 1,
            'hora' => '18:00:00',
            'idSala' => Sala::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->post('sesionvacia/crear', $sesion, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function crear_sesionvacia_repetida(){
        $sesion = [
            'pase' => SesionVacia::first()->pase,
            'hora' => SesionVacia::first()->hora,
            'idSala' => SesionVacia::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->actingAs($this->admin, 'admin')
            ->post('sesionvacia/crear', $sesion, $headers)
            ->assertStatus(403)
            ->assertSee('registrada.');
    }
}
