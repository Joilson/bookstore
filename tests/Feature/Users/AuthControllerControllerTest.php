<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldCreateEntity(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $response = $this->postJson('/api/auth', [
            'email' => $user->email, 'password' => 'password123'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'type',
            'expiresIn',
        ]);
    }

}
