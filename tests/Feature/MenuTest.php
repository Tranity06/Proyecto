<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Administrador;
use App\Models\Menu;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class MenuTest extends TestCase
{
    use RefreshDatabase;
    
    protected $admin;
    protected $menu;

    public function setUp()
    {
        parent::setUp();

        $this->admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ]);

        $this->menu = Menu::create([
            'nombre' => 'menu',
        ]);
    }

    public function crear_menu_sin_admin() {
        $this->get('menus/crear')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    public function crear_menu_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('/menus/crear')
            ->assertStatus(201);
    }

    /**********************************************************
     *          RUTA - GET menus/mostrar
     **********************************************************/
    /** @test */
    public function mostrar_menus_sin_admin() {
        $this->get('menus/mostrar')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function mostrar_menus_con_admin() {
        $this->actingAs($this->admin, 'admin')
            ->get('menus/mostrar')
            ->assertStatus(200);
    }

    /**********************************************************
     *          RUTA - POST '/menus/'
     **********************************************************/

    /** @test */
    public function crear_menu_usuario_logueado()
    {
        $menu = [
            'nombre' => 'rico'
        ];
        
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('/menus/crear', $menu, $headers)
            ->assertStatus(201);
    }

    /**********************************************************
     *          RUTA - PUT menus/
     **********************************************************/
    /** @test */
    public function modificar_menu_sin_admin() {
        $this->post('menus/'.$this->menu->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function modificar_menu_con_admin() {
        $idmenu = ['id' => $this->menu->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('menus/'.$idmenu['id'], $headers)
            ->assertStatus(200);
    }

    /** @test */
    public function modificar_menu_no_registrado() {
        $idmenu = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->post('menus/'.$idmenu['id'], $headers)
            ->assertStatus(400);
    }

    /**********************************************************
     *          RUTA - DELETE menus/borrar
     **********************************************************/
    /** @test */
    public function borrar_menu_sin_admin() {
        $this->delete('menus/'.$this->menu->id)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function borrar_menu_con_admin() {
        $idmenu = ['id' => $this->menu->id];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->delete('menus/'.$idmenu['id'], $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function borrar_menu_no_registrado() {
        $idmenu = ['id' => 100];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($this->admin, 'admin')
            ->delete('menus/'.$idmenu['id'], $headers)
            ->assertStatus(400);
    }
}