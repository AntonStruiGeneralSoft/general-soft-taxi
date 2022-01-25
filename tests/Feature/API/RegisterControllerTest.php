<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\TestCase as PHPUnit;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_email_uniqueness()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'q2wl1bdk31@thejoker5.com',
            'password' => '12345',
            'firstName' => 'Richard',
            'lastName' => 'Miller',
            'role' => 'client',
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_no_make_field_in_car()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'a@example.com',
            'password' => '12345',
            'firstName' => 'Richard',
            'lastName' => 'Miller',
            'role' => 'driver',
            'car' => [
                'model' => 'raw',
                'year' => 2015,
                'color'=> 'black'
            ]
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_no_make_model_fields_in_car()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'a@example.com',
            'password' => '12345',
            'firstName' => 'Richard',
            'lastName' => 'Miller',
            'role' => 'driver',
            'car' => [
                'year' => 2015,
                'color'=> 'black'
            ]
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_incorrect_role()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'a@example.com',
            'password' => '12345',
            'firstName' => 'Richard',
            'lastName' => 'Miller',
            'role' => 'admin',
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_creating_client()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'a36231ffe00f3b5d96b29048c35b41a2@example.com',
            'password' => '12345',
            'firstName' => 'Richard',
            'lastName' => 'Miller',
            'role' => 'client',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $user = User::where('email', '=', 'a36231ffe00f3b5d96b29048c35b41a2@example.com')->first();

        PHPUnit::assertTrue((bool)$user);
        PHPUnit::assertEquals($user->role, 'client');

        $user->forceDelete();
    }

    public function test_creating_driver()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'a36231ffe00f3b5d96b29048c35b41a2@example.com',
            'password' => '12345',
            'firstName' => 'Richard',
            'lastName' => 'Miller',
            'role' => 'driver',
            'car' => [
                'make' => 'Toyota',
                'model' => 'raw',
                'year' => 2015,
                'color'=> 'black'
            ]
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $user = User::where('email', '=', 'a36231ffe00f3b5d96b29048c35b41a2@example.com')->first();

        PHPUnit::assertTrue((bool)$user);
        PHPUnit::assertEquals($user->role, 'driver');

        $user->forceDelete();
    }
}
