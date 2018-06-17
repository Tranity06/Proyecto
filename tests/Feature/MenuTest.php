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

        $this->menu = menu::create([
            'nombre' => 'menu',
        ]);
    }

    /**********************************************************
     *          RUTA - GET '/menu/'
     **********************************************************/

    /** @test */
    public function crear_menus_usuario_logueado()
    {

        menu::create([
            'nombre' => 'menu'
        ]);

        $this->get('web/menus/crear',$headers)
             ->assertStatus(201)
             ->assertJsonStructure([
                '*' => [
                    'id', 'nombre'
                ]
            ])
            ->assertJsonFragment(['nombre' => 'menu']);
    }

    /** @test */

    /**********************************************************
     *          RUTA - POST '/menus/'
     **********************************************************/

    /** @test */
    public function crear_menu_usuario_logueado()
    {
        $menu = [
            'nombre' => 'menu'
        ];

        $credentials = [
            'email' => $this->admin->email,
            'password' => '123456'
        ];
        $this->post('/web/login', $credentials);
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post(route('menus.crear'), $menu, $headers)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'menu']);
    }

    /** @test */
    public function crear_menu_usuario_no_logueado()
    {
        $menu = [
            'nombre' => 'menu'
        ];

        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->post(route('menus.crear'), $menu, $headers)
             ->assertStatus(403);
    }

    /**********************************************************
     *          RUTA - PUT '/menu/'
     **********************************************************/

    /** @test */
    public function update_menu_con_usuario_logueado()
    {
        $menu_modificado = [
            'nombre' => 'nuevo'
        ];
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->post('web/menus/'.$this->menu->id, $menu_modificado, $headers)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'nuevo']);
    }

    /** @test */
    public function update_menu_sin_usuario_logueado()
    {
        $menu_modificado = [
            'nombre' => 'nuevo'
        ];

        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->put('web/menu/'.$this->menu->id, $menu_modificado, $headers)
             ->assertStatus(403);
    }

    /** @test */
    public function update_menu_con_usuario_logueado_menu_no_existe()
    {
        $menu_modificado = [
            'nombre' => 'nuevo'
        ];
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->put('web/menu/222'.$this->menu->id, $menu_modificado, $headers)
             ->assertStatus(403);
    }

    /**********************************************************
     *          RUTA - DELETE '/menu/'
     **********************************************************/

     /** @test */
    public function delete_menu_con_usuario_logueado()
    {
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('web/menu/'.$this->menu->id, [], $headers)
             ->assertStatus(204)
             ->assertSee('Menu borrado.');
    }

    /** @test */
    public function delete_menu_sin_usuario_logueado()
    {
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->delete('web/menu/'.$this->menu->id,[], $headers)
             ->assertStatus(403);
    }

    /** @test */
    public function delete_menu_con_usuario_logueado_menu_no_existe()
    {
        $token = JWTAuth::fromadmin($this->admin);
        $headers = ['X-CSRF-TOKEN' => csrf_token(),
                    'Authorization' => 'Bearer '.$token];
        $this->delete('web/menu/555',[], $headers)
             ->assertStatus(400)
             ->assertSee('El menu indicado no existe.');
    }
}