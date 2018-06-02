<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Administrador;
use Artisan;
use App\Models\PlantillaSesion;

class PlantillaTest extends TestCase
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
        $this->seed('TestPlantillaSeeder');
    }

    /**********************************************************
     *          RUTA - GET plantillas
     **********************************************************/
    /** @test */
    public function mostrar_plantillas_admin(){
        $this->actingAs($this->admin, 'admin')
            ->get('plantillas')
            ->assertStatus(200)
            ->assertSee($this->admin->nombre)
            ->assertSee('Plantillas de sesiones.');
    }

    /** @test */
    public function mostrar_plantillas_no_admin(){
        $this->get('plantillas')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - GET plantilla
     **********************************************************/
    /** @test */
    public function ver_formulario_crear_plantilla_admin(){
        $this->actingAs($this->admin, 'admin')
            ->get('plantilla')
            ->assertStatus(200)
            ->assertSee($this->admin->name)
            ->assertSee('Crear nueva plantilla.');
    }

    /** @test */
    public function ver_formulario_crear_plantilla_no_admin(){
        $this->get('plantilla')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - POST plantilla (AJAX)
     **********************************************************/
    /** @test */
    public function crear_plantilla_admin(){
        $plantilla = [
            'nombre' => 'nueva',
            'descripcion' => 'Plantilla nueva'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('plantilla', $plantilla, $headers)
            ->assertStatus(201)
            ->assertSee('Plantilla nueva');
    }

    /** @test */
    public function crear_plantilla_no_admin(){
        $plantilla = [
            'nombre' => 'nueva',
            'descripcion' => 'Plantilla nueva'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('plantilla', $plantilla, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - POST plantilla/modificar (AJAX)
     **********************************************************/
    /** @test */
    public function modificar_plantilla_no_admin(){
        $plantilla = [
            'idPlantilla' => PlantillaSesion::first()->id,
            'nombre' => 'Nuevo nombre',
            'descripcion' => 'Descripcion nueva'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('plantilla/modificar', $plantilla, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function modificar_nombre_plantilla(){
        $plantilla = [
            'idPlantilla' => PlantillaSesion::first()->id,
            'nombre' => 'Nuevo nombre',
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('plantilla/modificar', $plantilla, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function modificar_descripcion_plantilla(){
        $plantilla = [
            'idPlantilla' => PlantillaSesion::first()->id,
            'descripcion' => 'Nueva descripcion',
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('plantilla/modificar', $plantilla, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function modificar_plantilla_no_registrada(){
        $plantilla = [
            'idPlantilla' => 22,
            'descripcion' => 'Nueva descripcion',
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('plantilla/modificar', $plantilla, $headers)
            ->assertStatus(403)
            ->assertSee('La plantilla no existe.');
    }

    /**********************************************************
     *          RUTA - POST plantilla/borrar (AJAX)
     **********************************************************/
    /** @test */
    public function borrar_plantilla_no_admin(){
        $plantilla = [
            'idPlantilla' => PlantillaSesion::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('plantilla/borrar', $plantilla, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_plantilla_admin(){
        $plantilla = [
            'idPlantilla' => PlantillaSesion::first()->id
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('plantilla/borrar', $plantilla, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_plantilla_no_registrada(){
        $plantilla = [
            'idPlantilla' => 22
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('plantilla/borrar', $plantilla, $headers)
            ->assertStatus(403)
            ->assertSee('La plantilla no existe.');
    }
}
