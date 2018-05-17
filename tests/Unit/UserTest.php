<?php

namespace Tests\Unit;

use App\Mail\VerificarEmail;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_user()
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
    public function it_can_verify_an_user()
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
    public function user_is_already_verified()
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


}
