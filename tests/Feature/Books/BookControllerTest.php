<?php

declare(strict_types=1);

namespace Tests\Feature\Books;

use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\HasAuthentication;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use HasAuthentication, RefreshDatabase;

    public function testShouldCreateEntity(): void
    {
        $subject = Subject::factory()->create();
        $author = Author::factory()->create();

        $response = $this->postJson('/api/books', [
            "title" => "livro 1",
            "publisher" => "Editora Abril",
            "edition" => 1,
            "publicationYear" => '2019',
            "price" => 22.57,
            "subjects" => [$subject->id],
            "authors" => [$author->id]
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            "title" => "livro 1",
            "publisher" => "Editora Abril",
            "edition" => 1,
            "publicationYear" => '2019',
            "price" => 22.57,
        ]);

        $response->assertJsonStructure([
            'book' => [
                'subjects' => [
                    "*" => [
                        'id',
                        'description',
                        'updated_at',
                        'created_at'
                    ]
                ]
            ]
        ]);

        $response->assertJsonStructure([
            'book' => [
                'authors' => [
                    "*" => [
                        'id',
                        'name',
                        'updated_at',
                        'created_at'
                    ]
                ]
            ]
        ]);
    }

    public function testShouldUpdateEntity(): void
    {
        $entity = Book::factory()->create();
        $subject = Subject::factory()->create();
        $author = Author::factory()->create();

        $response = $this->putJson("/api/books/{$entity->id}", [
            "title" => "livro 2",
            "publisher" => "Editora Abril",
            "edition" => 1,
            "publicationYear" => '2019',
            "price" => 22.57,
            "subjects" => [$subject->id],
            "authors" => [$author->id]
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "title" => "livro 2"
        ]);
        $response->assertJsonFragment([
            "id" => $entity->id
        ]);
    }

    public function testShouldListEntities(): void
    {
        $entity = Book::factory()->create();

        $response = $this->get("/api/books/", [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'publisher',
                    'edition',
                    'publicationYear',
                    'price',
                    'subjects' => [
                        "*" => [
                            'id',
                            'description',
                            'updated_at',
                            'created_at'
                        ]
                    ],
                    'authors' => [
                        "*" => [
                            'id',
                            'name',
                            'updated_at',
                            'created_at'
                        ]
                    ],
                ]
            ]
        ]);
    }

    public function testShouldDeleteEntity(): void
    {
        $entity = Book::factory()->create();

        $response = $this->delete("/api/books/{$entity->id}", [], [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
    }

    public function testShouldGetEntity(): void
    {
        $book = Book::factory()->create();

        $response = $this->get("/api/books/{$book->id}", [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth()
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'book' => [
                'title',
                'publisher',
                'edition',
                'publicationYear',
                'price',
                'subjects' => [
                    "*" => [
                        'id',
                        'description',
                        'updated_at',
                        'created_at'
                    ]
                ],
                'authors' => [
                    "*" => [
                        'id',
                        'name',
                        'updated_at',
                        'created_at'
                    ]
                ],
            ]
        ]);
    }
}
