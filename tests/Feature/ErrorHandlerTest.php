<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Books\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorHandlerTest extends TestCase
{
    use HasAuthentication, RefreshDatabase;

    public function testResourceDuplicated(): void
    {
        $other = Author::factory()->create();
        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", ['name' => $other->name], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(422);
    }

    public function testResourceNotFount(): void
    {
        $response = $this->putJson("/api/authors/9999", ['name' => 'xxxxxx asdasd'], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(400);
    }
}
