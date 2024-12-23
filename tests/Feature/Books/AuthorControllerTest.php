<?php

declare(strict_types=1);

namespace Tests\Feature\Books;

use App\Models\Books\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\HasAuthentication;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use HasAuthentication, RefreshDatabase;

    public function testShouldCreateEntity(): void
    {
        $response = $this->postJson('/api/authors', ['name' => 'Test Author'], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'Test Author'
        ]);
    }

    public function testShouldUpdateEntity(): void
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", ['name' => 'Test Author 1'], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Test Author 1'
        ]);
    }

    public function testShouldListEntities(): void
    {
        $author = Author::factory()->create();

        $response = $this->get("/api/authors/", [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'updated_at',
                    'created_at'
                ]
            ]
        ]);
    }

    public function testShouldDeleteEntity(): void
    {
        $author = Author::factory()->create();

        $response = $this->delete("/api/authors/{$author->id}", [], [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
    }

    public function testShouldGetEntity(): void
    {
        $author = Author::factory()->create();

        $response = $this->get("/api/authors/{$author->id}", [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'author' => [
                'id',
                'name',
                'updated_at',
                'created_at'
            ]
        ]);
    }
}
