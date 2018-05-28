<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sala;
use App\Models\Administrador;
use Artisan;

class ButacaTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $sala;

    public function setUp()
    {
        parent::setUp();

        $this->admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);

        Artisan::call('migrate');
        $this->seed('TestButacaSeeder');

        $this->sala = Sala::get()->first();
    }

    /**********************************************************
     *          RUTA - POST butaca/bloquear
     **********************************************************/
    /** @test */
    public function bloquear_butaca_no_admin(){
        $datos = [
            'idSala' => $this->sala->id,
            'fila' => 2,
            'butacas' => [1,2]
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('butaca/bloquear', $datos, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function bloquear_butacas(){
        $datos = [
            'idSala' => $this->sala->id,
            'fila' => 2,
            'butacas' => [1,2]
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('butaca/bloquear', $datos, $headers)
            ->assertStatus(201)
            ->assertJsonFragment([
                'sala_id' => (string)$this->sala->id,
                'fila' => '2',
                'estado' => 1
            ])
            ->assertJsonMissing([
                'estado' => 0
            ]);
    }

    /** @test */
    public function bloquear_fila(){
        $datos = [
            'idSala' => $this->sala->id,
            'fila' => 2,
            'all' => true
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('butaca/bloquear', $datos, $headers)
            ->assertStatus(201)
            ->assertJsonFragment([
                'sala_id' => (string)$this->sala->id,
                'fila' => '2',
                'estado' => 1
            ])
            ->assertJsonMissing([
                'estado' => 0
            ]);
    }

    /** @test */
    public function bloquear_butaca_fila_no_registrada(){
        $datos = [
            'idSala' => $this->sala->id,
            'fila' => 10,
            'butacas' => [1,2]
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('butaca/bloquear', $datos, $headers)
            ->assertStatus(403)
            ->assertSee('La fila o butaca no existe.');
    }

    /** @test */
    public function bloquear_butaca_no_registrada(){
        $datos = [
            'idSala' => $this->sala->id,
            'fila' => 10,
            'butacas' => [1,20]
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('butaca/bloquear', $datos, $headers)
            ->assertStatus(403)
            ->assertSee('La fila o butaca no existe.');
    }

    /**********************************************************
     *          RUTA - POST butaca/desbloquear
     **********************************************************/
    /** @test */
    public function desbloquear_butaca_no_admin(){
        $datos = [
            'idButaca' => $this->sala->butacas()->first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('butaca/desbloquear', $datos, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function desbloquear_butaca(){
        $datos = [
            'idButaca' => $this->sala->butacas()->first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('butaca/desbloquear', $datos, $headers)
            ->assertStatus(201)
            ->assertSee('Butaca actualizada.');
    }

    /** @test */
    public function desbloquear_butaca_no_registrada(){
        $datos = [
            'idButaca' => 100
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('butaca/desbloquear', $datos, $headers)
            ->assertStatus(403)
            ->assertSee('La fila o butaca no existe.');
    }
}
