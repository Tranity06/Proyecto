<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sala;
use App\Models\Administrador;
use Artisan;

class SalaAdminTest extends TestCase
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
        $this->seed('TestSalaSeeder');
    }

    /**********************************************************
     *          RUTA - GET salas
     **********************************************************/
    /** @test */
    public function mostrar_salas_admin(){
        $this->actingAs($this->admin, 'admin')
            ->get('salas')
            ->assertStatus(200)
            ->assertSee($this->admin->nombre)
            ->assertSee('Lista de salas registradas.');
    }

    /** @test */
    public function mostrar_salas_no_admin(){
        $this->get('salas')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - GET sala/{idSala}
     **********************************************************/
    /** @test */
    public function mostrar_info_sala_admin(){
        $sala = Sala::first();
        $this->actingAs($this->admin, 'admin')
            ->get('sala/'.$sala->id)
            ->assertStatus(200)
            ->assertSee($this->admin->nombre)
            ->assertSee('Detalle sala '.$sala->id);
    }

    /** @test */
    public function mostrar_info_sala_no_admin(){
        $sala = Sala::first();
        $this->get('sala/'.$sala->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - GET sala
     **********************************************************/
    /** @test */
    public function ver_formulario_crear_sala_admin(){
        $this->actingAs($this->admin, 'admin')
            ->get('sala')
            ->assertStatus(200)
            ->assertSee($this->admin->name)
            ->assertSee('Crear nueva sala.');

    }

    /** @test */
    public function ver_formulario_crear_no_admin(){
        $this->get('sala')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - POST sala (AJAX)
     **********************************************************/
    /** @test */
    public function crear_sala_admin(){
        $sala = [
            'numero' =>10,
            'filas' => 3,
            'butacas' => 5
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala', $sala, $headers)
            ->assertStatus(201)
            ->assertSee('Sala creada.');
    }

    /** @test */
    public function crear_sala_no_admin(){
        $sala = [
            'numero' =>10,
            'filas' => 3,
            'butacas_fila' => 5
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('sala', $sala, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function crear_sala_repetida(){
        $sala = [
            'numero' =>1,
            'filas' => 3,
            'butacas' => 5
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('La sala ya existe.');
    }

    /** @test */
    public function crear_sala_datos_incorrectos(){
        $sala = [
            'numero' => 'abc',
            'filas' => 3,
            'butacas_fila' => 5
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('Los datos introducidos no son correctos.');
    }

    /**********************************************************
     *          RUTA - POST sala/borrar (AJAX)
     **********************************************************/
    /** @test */
    public function borrar_sala_admin(){
        $sala = [
            'idSala' => 2,
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_sala_no_admin(){
        $sala = [
            'idSala' => Sala::first()->id,
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('sala/borrar', $sala, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_sala_no_registrada(){
        $sala = [
            'idSala' => 20,
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('La sala indicada no existe.');
    }

    /** @test */
    public function borrar_sala_con_sesiones(){
        $sala = [
            'idSala' => Sala::first()->numero,
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('La sala tiene sesiones programadas.');
    }

    /**********************************************************
     *          RUTA - POST sala/modificar (AJAX)
     **********************************************************/
    /** @test */
    /* public function modificar_numero_sala_admin(){
        $sala = [
            'idSala' => Sala::first()->id,
            'numero' => '20'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(201)
            ->assertSee('Sala modificada.');
    } */

    /** @test */
    /* public function modificar_filas_sala(){
        $sala = [
            'idSala' => Sala::first()->id,
            'filas' => '7'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(201)
            ->assertSee('Sala modificada.');
    } */

    /** @test */
    /* public function modificar_butacas_sala(){
        $sala = [
            'idSala' => Sala::first()->id,
            'butacas' => '3'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(201)
            ->assertSee('Sala modificada.');
    } */

    /** @test */
    /* public function modificar_sala_no_admin(){
        $sala = [
            'idSala' => Sala::first()->id,
            'filas' => '6'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('sala/modificar', $sala, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    } */

    /** @test */
    /* public function modificar_sala_no_registrada(){
        $sala = [
            'idSala' => 20,
            'filas' => '6'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/modificar', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('La sala indicada no existe.');
    } */

    /** @test */
    /* public function modificar_sala_numero_repetido(){
        $sala = [
            'idSala' => Sala::first()->id,
            'numero' => '2'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('La sala ya está registrada.');
    } */

    /** @test */
    /* public function modificar_sala_datos_incorrectos(){
        $sala = [
            'idSala' => Sala::first()->id,
            'numero' => 'asd'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('sala/borrar', $sala, $headers)
            ->assertStatus(403)
            ->assertSee('La sala ya está registrada.');
    } */
}
