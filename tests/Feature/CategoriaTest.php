<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Administrador;
use App\Models\Categoria;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class CategoriaTest extends TestCase
{
    use RefreshDatabase;
    
    protected $admin;
    protected $categoria;

    public function setUp()
    {
        parent::setUp();

        $this->admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);

        $this->categoria = Categoria::create([
            'nombre' => 'rico',
        ]);
    }

    public function crear_categoria_sin_admin() {
        $this->get('categorias/crear')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    public function crear_categoria_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('/categorias/crear')
            ->assertStatus(200);
    }

    /**********************************************************
     *          RUTA - GET categorias/mostrar
     **********************************************************/
    /** @test */
    public function mostrar_categorias_sin_admin() {
        $this->get('categorias/mostrar')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function mostrar_categorias_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('categorias/mostrar')
            ->assertStatus(200);
    }

    /**********************************************************
     *          RUTA - POST '/categorias/'
     **********************************************************/

    /** @test */
    public function crear_categoria_usuario_logueado()
    {
        $categoria = [
            'nombre' => 'rico'
        ];
        
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('/categorias/crear', $categoria, $headers)
            ->assertStatus(201);
    }

    /**********************************************************
     *          RUTA - PUT categorias/
     **********************************************************/
    /** @test */
    public function modificar_categoria_sin_admin() {
        $this->post('categorias/'.$this->categoria->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function modificar_categoria_con_admin() {
        $idCategoria = ['id' => $this->categoria->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('categorias/'.$idCategoria, $headers)
            ->assertStatus(200);
    }

    /** @test */
    public function modificar_categoria_no_registrada() {
        $idCategoria = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('categorias/'.$idCategoria, $headers)
            ->assertStatus(400);
    }

    /**********************************************************
     *          RUTA - DELETE categorias/borrar
     **********************************************************/
    /** @test */
    public function borrar_categoria_sin_admin() {
        $this->delete('categorias/'.$this->categoria->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_categoria_con_admin() {
        $idCategoria = ['id' => $this->categoria->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->delete('categorias/'.$idCategoria, $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_categoria_no_registrada() {
        $idCategoria = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->delete('categorias/'.$idCategoria, $headers)
            ->assertStatus(400);
    }
}