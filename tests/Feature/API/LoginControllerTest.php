<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_no_data()
    {
        $response = $this->postJson('/api/login');

        $response->assertStatus(400);
    }

    public function test_incorrect_password()
    {
        $response = $this->postJson('/api/login',[
            'email' => 'q2wl1bdk31@thejoker5.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => 'Wrong password',
            ]);;
    }

    public function test_incorrect_email()
    {
        $response = $this->postJson('/api/login',[
            'email' => 'example.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(400);
    }

    public function test_admin_login()
    {
        $response = $this->postJson('/api/login',[
            'email' => 'q2wl1bdk31@thejoker5.com',
            'password' => 'qwe123',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(
                'accessToken', 'refreshToken', 'expirationTime', 'tokenType'));
    }
}
