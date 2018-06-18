<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Administrador;
use App\Models\Categoria;
use App\Models\Producto;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class ProductoTest extends TestCase
{
    use RefreshDatabase;
    
    protected $admin;
    protected $categoria;
    protected $producto;

    public function setUp()
    {
        parent::setUp();

        $this->admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);

        $this->categoria = Categoria::create([
            'nombre' => 'categoria_producto',
        ]);

        $this->producto = Producto::create([
            'nombre' => 'producto',
            'precio' => 1,
            'imagen' => 'C:\fakepath\foto.png',
            'categoria_id' => $this->categoria->id,
        ]);
    }

    public function crear_producto_sin_admin() {
        $this->get('productos/crear')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    public function crear_producto_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('/productos/crear')
            ->assertStatus(201);
    }

    /**********************************************************
     *          RUTA - GET productos/mostrar
     **********************************************************/
    /** @test */
    public function mostrar_productos_sin_admin() {
        $this->get('productos/mostrar')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function mostrar_productos_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('productos/mostrar')
            ->assertStatus(200);
    }

    /**********************************************************
     *          RUTA - POST '/productos/'
     **********************************************************/

    /** @test */
    public function crear_producto_usuario_logueado()
    {
        $producto = [
            'nombre' => 'nuevo',
            'precio' => 1,
            'imagen' => 'C:\fakepath\foto.png',
            'categoria_id' => $this->categoria->id,
        ];
        
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('/productos/crear', $producto, $headers)
            ->assertStatus(201);
    }

    /**********************************************************
     *          RUTA - PUT productos/
     **********************************************************/
    /** @test */
    public function modificar_producto_sin_admin() {
        $this->post('productos/'.$this->producto->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function modificar_producto_con_admin() {
        $producto = [
            'id' => Producto::first()->id,
            'nombre' => 'otronombre',
            'precio' => 2,
            'categoria_id' => $this->categoria->id
        ];
        $idProducto = ['id' => $this->producto->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('productos/'.$idProducto['id'], $producto, $headers)
            ->assertStatus(200);
    }

    /** @test */
    public function modificar_producto_no_registrada() {
        $idProducto = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('productos/'.$idProducto['id'], $headers)
            ->assertStatus(403);
    }

    /**********************************************************
     *          RUTA - DELETE productos/borrar
     **********************************************************/
    /** @test */
    public function borrar_producto_sin_admin() {
        $this->delete('productos/'.$this->producto->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_producto_con_admin() {
        $idProducto = ['id' => $this->producto->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->delete('productos/'.$idProducto['id'], $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_producto_no_registrada() {
        $idProducto = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->delete('productos/'.$idProducto['id'], $headers)
            ->assertStatus(400);
    }
}