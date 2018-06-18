<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\TestCase;

class PerfilControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = User::create([
            'id' => 1,
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'telefono' => 654987321,
            'is_verified' => 1
        ]);
    }

    /**********************************************************
     *          RUTA - GET '/resena/'
     **********************************************************/

    /** @test */
    public function it_should_change_the_email_correctly()
    {

        $token = JWTAuth::fromUser($this->user);

        $user = [
            'email' => 'email@example.com',
        ];

        $this->post('/api/datos/email?token=' . $token, $user)
            ->assertStatus(201)
            ->assertJsonFragment(['Success']);

        $this->assertDatabaseHas('users', [
            'email' => 'email@example.com'
        ]);
    }

    /** @test */
    public function it_should_change_el_telefono_correctly()
    {

        $token = JWTAuth::fromUser($this->user);

        $user = [
            'telefono' => '632245534',
        ];

        $this->post('/api/datos/telefono?token=' . $token, $user)
            ->assertStatus(201)
            ->assertJsonFragment(['Success']);

        $this->assertDatabaseHas('users', [
            'telefono' => '632245534'
        ]);
    }

    /** @test */
    public function it_should_confirm_password_correctly()
    {

        $token = JWTAuth::fromUser($this->user);

        $user = [
            'paso' => 1,
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $this->post('/api/datos/clave?token=' . $token, $user)
            ->assertStatus(200)
            ->assertJsonFragment([true]);
    }

    /** @test */
    public function it_should_change_password_correctly()
    {

        $token = JWTAuth::fromUser($this->user);

        $user = [
            'paso' => 2,
            'password' => '123455',
            'password_confirmation' => '123455'
        ];

        $this->post('/api/datos/clave?token=' . $token, $user)
            ->assertStatus(200)
            ->assertJsonFragment(['token']);
    }

    /** @test */
    public function it_should_response_wrong_data()
    {

        $token = JWTAuth::fromUser($this->user);

        $user = [
            'paso' => 2,
            'password' => '12',
        ];

        $this->post('/api/datos/clave?token=' . $token, $user)
            ->assertStatus(400)
            ->assertJson(['success' => false, 'error' => 'Los datos introducidos no son correctos.']);
    }

    /** @test */
    public function it_doesnt_have_correct_credentials_step_1()
    {

        $token = JWTAuth::fromUser($this->user);

        $user = [
            'paso' => 1,
            'password' => '123455',
            'password_confirmation' => '123455'
        ];

        $this->post('/api/datos/clave?token=' . $token, $user)
            ->assertStatus(401)
            ->assertJsonFragment([false]);
    }


    /** @test */
    public function it_shoud_throw_an_error_cause_image_is_required()
    {

        $token = JWTAuth::fromUser($this->user);

        $this->post('/api/datos/avatar?token=' . $token)
            ->assertStatus(400)
            ->assertJsonFragment(['error']);
    }


    /*    public function it_should_return_permiso_denegado()
        {

            $token = 'asdasd';

            $user = [
                'email' => $this->user->email,
            ];

            $this->post('/api/datos/email?token='.$token, $user)
                ->assertStatus(403)
                ->assertJsonFragment(['Permiso denegado']);
        }*/


}