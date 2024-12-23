<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\HasAuthentication;
use Tests\TestCase;

class AddUserControllerTest extends TestCase
{
    use HasAuthentication, RefreshDatabase;

    public function testShouldCreateEntity(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'test', 'email' => 'test@test.com', 'password' => 'password'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'test',
            'email' => 'test@test.com',
        ]);
    }

}
