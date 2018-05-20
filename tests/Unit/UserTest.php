<?php

namespace Tests\Unit;

use App\Mail\VerificarEmail;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register()
    {
        Mail::fake();

        $user = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'telefono' => 623456789,
        ];

        $this->post(route('auth.register'), $user)
             ->assertStatus(201)
             ->assertJson(['success' => true, 'message' => 'Thanks for signing up! Please check your email to complete your registration.']);

        Mail::assertSent(VerificarEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user['email']);
        });

    }

    /** @test */
    public function it_sends_wrong_data_to_register()
    {
        Mail::fake();

        $user = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secretA',
            'telefono' => 123456789,
        ];

        $this->post(route('auth.register'), $user)
            ->assertStatus(400)
            ->assertJson(['success' => false, 'error' => 'Los datos introducidos no son correctos.']);

    }

    /** @test */
    public function it_can_verify()
    {
        $user = factory(User::class)->create();
        $user_verification = UserVerification::create([
            "user_id" => $user->id,
            "token" => str_random(30)
            ]);

        $this->get('user/verify/'.$user_verification->token)
             ->assertStatus(200)
             ->assertJson([ 'success' => true, 'message' => 'You have successfully verified your email address.']);

    }

    /** @test */
    public function it_is_already_verified()
    {
        $user = factory(User::class)->create();
        $user->update(['is_verified' => 1]);

        $user_verification = UserVerification::create([
            "user_id" => $user->id,
            "token" => str_random(30)
        ]);

        $this->get('user/verify/'.$user_verification->token)
            ->assertStatus(200)
            ->assertJson([ 'success' => true, 'message' => 'Account already verified...']);

    }

    /** @test */
    public function verification_code_is_invalid()
    {
        $user = factory(User::class)->create();

        $token = str_random(30);

        $this->get('user/verify/'.$token)
            ->assertStatus(400)
            ->assertJson([ 'success' => false, 'error' => 'Verification code is invalid.']);

    }

    /** @test */
    public function it_can_login()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('123456')
        ]);
        $credentials = [
            'email' => $user->email,
            'password' => '123456',
        ];

        self::assertNotEmpty(JWTAuth::attempt($credentials));
    }

    /** @test */
    public function it_sends_wrong_data_to_login()
    {
        factory(User::class)->create([
            'password' => bcrypt('123456')
        ]);
        $credentials = [
            'password' => '123456',
        ];

        $this->post(route('auth.login'), $credentials)
            ->assertStatus(400)
            ->assertJsonValidationErrors('email');

    }

    /** @test */
    public function it_is_unauthorized()
    {
        $user = factory(User::class)->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'nosequecontraseñaes',
        ];

        $this->post(route('auth.login'),$credentials)
            ->assertStatus(401)
            ->assertJson(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.']);
    }

    /** @test */
    public function it_can_logout()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('123456')
        ]);
        $credentials = [
            'email' => $user->email,
            'password' => '123456',
        ];
        $token = JWTAuth::attempt($credentials);

        $this->get(route('auth.logout').'?token='.$token)
             ->assertJson(['success' => true, 'message' => "You have successfully logged out."]);
    }

    /** @test */
    public function it_can_recovery_password()
    {
        Notification::fake();

        $user = factory(User::class)->create();
        $userData = [
            'email' => $user->email,
        ];

        $this->post(route('auth.recover'),$userData)
             ->assertStatus(200)
             ->assertJson(['success' => true, 'message' => 'A reset email has been sent! Please check your email.']);
        Notification::assertSentTo($user, ResetPassword::class);
    }

    /** @test */
    public function it_cant_find_email()
    {
        $userData = [
            'email' => $this->faker->email,
        ];

        $this->post(route('auth.recover'),$userData)
             ->assertStatus(401)
             ->assertJson(['success' => false, 'error' => 'Your email address was not found.'],200);
    }


}
