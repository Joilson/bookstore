<?php

declare(strict_types=1);

namespace Tests\Feature\Books;

use App\Models\Books\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\HasAuthentication;
use Tests\TestCase;

class SubjectControllerTest extends TestCase
{
    use HasAuthentication, RefreshDatabase;

    public function testShouldCreateEntity(): void
    {
        $response = $this->postJson('/api/subjects', ['description' => 'test description'], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'description' => 'test description'
        ]);
    }

    public function testShouldUpdateEntity(): void
    {
        $entity = Subject::factory()->create();

        $response = $this->putJson("/api/subjects/{$entity->id}", ['description' => 'test description 1'], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'description' => 'test description 1'
        ]);
    }

    public function testShouldListEntities(): void
    {
        $entity = Subject::factory()->create();

        $response = $this->get("/api/subjects/", [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'updated_at',
                    'created_at'
                ]
            ]
        ]);
    }

    public function testShouldDeleteEntity(): void
    {
        $entity = Subject::factory()->create();

        $response = $this->delete("/api/subjects/{$entity->id}", [], [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
    }

    public function testShouldGetEntity(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->get("/api/subjects/{$subject->id}", [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'subject' => [
                'id',
                'description',
                'updated_at',
                'created_at'
            ]
        ]);
    }
}
