<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Administrador;
use App\Models\User;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**********************************************************
     *          RUTA - '/admin'
     **********************************************************/
    /** @test */
    public function ruta_admin(){
        $this->get('/admin')
            ->assertStatus(302)
            ->assertRedirect('/admin/login');
    }

    /**********************************************************
     *          RUTA - '/admin/login'
     **********************************************************/
    /** @test */
    public function ruta_login_sin_sesion(){
        $this->get('/admin/login')
            ->assertStatus(200)
            ->assertSee('Autenticarse para iniciar la sesión');
    }

    /** @test */
    public function ruta_login_con_sesion(){
        $admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin)
            ->get('/admin/login')
            ->assertStatus(200)
            ->assertSee('Admin');
    }

    /**********************************************************
     *          RUTA - '/admin/settings'
     **********************************************************/
    /** @test */
    public function ruta_settings_sin_sesion(){
        $this->get('/admin/settings')
        ->assertStatus(302)
        ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_settings_con_sesion(){
        $admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin, 'admin')
            ->get('/admin/settings')
            ->assertStatus(200)
            ->assertSee($admin->name)
            ->assertSee('Datos de la cuenta');
    }

    /** @test */
    public function ruta_settings_con_sesion_user(){
        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'telefono' => 654987321,
            'is_verified' => 1
        ]);
        $this->actingAs($user, 'api')
            ->get('/admin/settings')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /**********************************************************
     *          RUTA - '/admin/comprobar'
     **********************************************************/
    /** @test */
    public function ruta_comprobar_get_sin_sesion(){
        $this->get('admin/comprobar')
        ->assertStatus(302)
        ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_comprobar_get_con_sesion(){
        $admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin, 'admin')
            ->get('admin/comprobar')
            ->assertStatus(302)
            ->assertRedirect('admin/settings');
    }

    /** @test */
    public function ruta_comprobar_post_sin_sesion(){
        $datos = ['valor' => 'John'];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('admin/comprobar', $datos, $headers)
        ->assertStatus(302)
        ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_comprobar_post_con_sesion(){
        $admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = ['valor' => 'John'];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($admin, 'admin')
            ->post('admin/comprobar', $datos, $headers)
            ->assertStatus(201);
    }

    /**********************************************************
     *          RUTA - '/admin/modificaradmin'
     **********************************************************/
    /** @test */
    public function ruta_modificaradmin_get_sin_sesion(){
        $this->get('admin/modificaradmin')
        ->assertStatus(302)
        ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_modificaradmin_get_con_sesion(){
        $admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin, 'admin')
            ->get('admin/modificaradmin')
            ->assertStatus(302)
            ->assertRedirect('admin/settings');
    }

    /** @test */
    public function ruta_modificaradmin_post_sin_sesion(){
        $datos = ['valor' => 'John'];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->post('admin/modificaradmin', $datos, $headers)
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_modificaradmin_post_con_sesion_no_superadmin(){
        $superadmin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $admin = Administrador::create([
            'id' => 2,
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'id' => 1,
            'name' => 'Ann',
            'email' => '',
            'password' => ''
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($admin, 'admin')
            ->post('admin/modificaradmin', $datos, $headers)
            ->assertStatus(200)
            ->assertSee('Permiso denegado.');
    }

    /** @test */
    public function ruta_modificaradmin_post_con_sesion_superadmin_nombre_correcto(){
        $superadmin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $admin = Administrador::create([
            'id' => 2,
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'id' => 2,
            'name' => 'Ann',
            'email' => '',
            'password' => ''
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($superadmin, 'admin')
            ->post('admin/modificaradmin', $datos, $headers)
            ->assertStatus(200)
            ->assertSee('Administradores registrados');
    }

    /** @test */
    public function ruta_modificaradmin_post_con_sesion_superadmin_nombre_incorrecto(){
        $superadmin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $admin = Administrador::create([
            'id' => 2,
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'id' => 2,
            'name' => 'Admin',
            'email' => '',
            'password' => ''
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($superadmin)
            ->post('admin/modificaradmin', $datos, $headers)
            ->assertStatus(302);
    }

    /** @test */
    public function ruta_modificaradmin_post_con_sesion_superadmin_email_correcto(){
        $superadmin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $admin = Administrador::create([
            'id' => 2,
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'id' => 2,
            'name' => '',
            'email' => 'nuevo@mail.com',
            'password' => ''
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($superadmin, 'admin')
            ->post('admin/modificaradmin', $datos, $headers)
            ->assertStatus(200)
            ->assertSee('Administradores registrados');
    }

    /** @test */
    public function ruta_modificaradmin_post_con_sesion_superadmin_email_incorrecto(){
        $superadmin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $admin = Administrador::create([
            'id' => 2,
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'id' => 2,
            'name' => '',
            'email' => 'admin@admin.com',
            'password' => ''
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($superadmin)
            ->post('admin/modificaradmin', $datos, $headers)
            ->assertStatus(302);
    }

    /**********************************************************
     *          RUTA - '/admin/modificaradmin'
     **********************************************************/
    /** @test */
    public function ruta_modificarperfil_post_perfil_con_sesion(){
        $admin = Administrador::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'name' => 'Lorena',
            'email' => '',
            'password' => ''
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($admin, 'admin')
            ->post('admin/modificarperfil', $datos, $headers)
            ->assertStatus(200)
            ->assertSee('Datos de la cuenta');
    }


    /**********************************************************
     *          RUTA - '/admin/crearadministrador'
     **********************************************************/
    /** @test */
    public function ruta_crear_get_sin_sesion(){
        $this->get('admin/crearadministrador')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_crear_get_con_sesion_superadm(){
        $admin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin, 'admin')
            ->get('admin/crearadministrador')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }

    /** @test */
    public function ruta_crear_get_con_sesion_no_superadm(){
        $admin = Administrador::create([
            'id' => 5,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin, 'admin')
            ->get('admin/crearadministrador')
            ->assertStatus(200)
            ->assertSee('Permiso denegado.');
    }

    /** @test */
    public function ruta_crear_post_con_sesion_superadm(){
        $admin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => 'MMnn12-'
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($admin, 'admin')
            ->post('admin/crearadministrador', $datos, $headers)
            ->assertStatus(200)
            ->assertSee('Usuario creado');
    }

    /** @test */
    public function ruta_crear_post_con_sesion_no_superadm(){
        $admin = Administrador::create([
            'id' => 5,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $datos = [
            'name' => 'John',
            'email' => 'john@admin.com',
            'password' => bcrypt('123456')
        ];
        $headers = ['X-CSRF-TOKEN' => csrf_token() ];
        $this->actingAs($admin, 'admin')
            ->post('admin/crearadministrador', $datos, $headers)
            ->assertStatus(200)
            ->assertSee('Permiso denegado');
    }

    /**********************************************************
     *          RUTA - '/admin/administradores'
     **********************************************************/
    /** @test */
    public function ruta_administradores_get_sin_sesion(){
        $this->get('admin/administradores')
            ->assertStatus(302)
            ->assertRedirect('/admin');
    }

    /** @test */
    public function ruta_administradores_get_con_sesion(){
        $admin = Administrador::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $this->actingAs($admin, 'admin')
            ->get('admin/administradores')
            ->assertStatus(200)
            ->assertSee('Administradores registrados');
    }

    /**********************************************************
     *          RUTA - '/admin/borrar'
     **********************************************************/
        /** @test */
        public function ruta_borrar_get_sin_sesion(){
            $this->get('admin/borrar')
                ->assertStatus(302)
                ->assertRedirect('/admin');
        }
    
        /** @test */
        public function ruta_borrar_get_con_sesion(){
            $admin = Administrador::create([
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456')
            ]);
            $this->actingAs($admin)
                ->get('admin/borrar')
                ->assertStatus(302)
                ->assertRedirect('/admin');
        }
    
        /** @test */
        public function ruta_borrar_post_con_sesion_superadm(){
            $admin1 = Administrador::create([
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456')
            ]);
            $admin2 = Administrador::create([
                'id' => 5,
                'name' => 'John',
                'email' => 'john@admin.com',
                'password' => bcrypt('123456')
            ]);
            $datos = [
                'id' => 5
            ];
            $headers = ['X-CSRF-TOKEN' => csrf_token() ];
            $this->actingAs($admin1, 'admin')
                ->post('admin/borrar', $datos, $headers)
                ->assertStatus(204);
        }
    
        /** @test */
        public function ruta_borrar_post_con_sesion_no_superadm(){
            $admin1 = Administrador::create([
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456')
            ]);
            $admin2 = Administrador::create([
                'id' => 5,
                'name' => 'John',
                'email' => 'john@admin.com',
                'password' => bcrypt('123456')
            ]);
            $datos = [
                'id' => 1
            ];
            $headers = ['X-CSRF-TOKEN' => csrf_token() ];
            $this->actingAs($admin2, 'admin')
                ->post('admin/borrar', $datos, $headers)
                ->assertStatus(403);
        }
}
