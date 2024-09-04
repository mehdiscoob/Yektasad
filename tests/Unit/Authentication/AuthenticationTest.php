<?php

namespace Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_user_registration()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(201);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function test_user_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('testpassword')
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => 'testpassword'
        ];

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(200);
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function test_user_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->post('/api/logout');

        $response->assertStatus(200);
    }
}
