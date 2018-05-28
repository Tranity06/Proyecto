<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sala;

class ButacaTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $sala;
    protected $headers;

    public function setUp()
    {
        parent::setUp();
        $this->headers = ['X-CSRF-TOKEN' => csrf_token() ];

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
        ]
        $this->post('salas')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }
}
