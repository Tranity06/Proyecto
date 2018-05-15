<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_user()
    {
        $data = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'telefono' => 623456789,
        ];

        $this->post(route('auth.register'), $data)
            ->assertStatus(201)
            ->assertJson(['success' => true, 'message' => 'Thanks for signing up! Please check your email to complete your registration.']);
    }
}
