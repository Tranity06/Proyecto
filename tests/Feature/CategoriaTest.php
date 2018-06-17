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

    /**********************************************************
     *          RUTA - GET '/categoria/'
     **********************************************************/

    /** @test */
    public function crear_categorias_usuario_logueado()
    {

        Categoria::create([
            'nombre' => 'rico'
        ]);

        $this->get(route('categoria.get'),$headers)
             ->assertStatus(201)
             ->assertJsonStructure([
                '*' => [
                    'id', 'nombre'
                ]
            ])
            ->assertJsonFragment(['nombre' => 'rico']);
    }

    /** @test */

    /**********************************************************
     *          RUTA - POST '/categorias/'
     **********************************************************/

    /** @test */
    public function crear_categoria_usuario_logueado()
    {
        $categoria = [
            'nombre' => 'rico'
        ];

        $credentials = [
            'email' => $this->admin->email,
            'password' => '123456'
        ];
        $this->post('/web/login', $credentials);
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('categorias.crear'), $categoria, $headers)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'rico']);
    }

    /** @test */
    public function crear_categoria_usuario_no_logueado()
    {
        $categoria = [
            'nombre' => 'rico'
        ];

        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->post(route('categorias.crear'), $categoria, $headers)
             ->assertStatus(403);
    }

    /**********************************************************
     *          RUTA - POST '/categoria/'
     **********************************************************/

    /** @test */
    public function update_categoria_con_usuario_logueado()
    {
        $categoria_modificada = [
            'nombre' => 'nuevo'
        ];
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post('web/categorias/'.$this->categoria->id, $categoria_modificada, $headers)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'nuevo']);
    }

    /** @test */
    public function update_categoria_sin_usuario_logueado()
    {
        $categoria_modificada = [
            'nombre' => 'nuevo'
        ];

        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->put('web/categoria/'.$this->categoria->id, $categoria_modificada, $headers)
             ->assertStatus(403);
    }

    /** @test */
    public function update_categoria_con_usuario_logueado_categoria_no_existe()
    {
        $categoria_modificada = [
            'nombre' => 'nuevo'
        ];
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('web/categoria/222'.$this->categoria->id, $categoria_modificada, $headers)
             ->assertStatus(403);
    }

    /**********************************************************
     *          RUTA - DELETE '/categoria/'
     **********************************************************/

     /** @test */
    public function delete_categoria_con_usuario_logueado()
    {
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('web/categoria/'.$this->categoria->id, [], $headers)
             ->assertStatus(204)
             ->assertSee('Categoria borrada.');
    }

    /** @test */
    public function delete_categoria_sin_usuario_logueado()
    {
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->delete('web/categoria/'.$this->categoria->id,[], $headers)
             ->assertStatus(403);
    }

    /** @test */
    public function delete_categoria_con_usuario_logueado_categoria_no_existe()
    {
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('web/categoria/555',[], $headers)
             ->assertStatus(400)
             ->assertSee('La categoría indicada no existe.');
    }
}