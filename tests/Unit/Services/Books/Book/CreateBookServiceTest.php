<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Book;

use App\DTOs\Inputs\AddBookDTO;
use App\Exceptions\FailDuringPersistence;
use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Subject;
use App\Services\Books\Book\CreateBookService;
use Tests\TestCase;

class CreateBookServiceTest extends TestCase
{
    public function testCreateEntity(): void
    {
        $service = $this->app->get(CreateBookService::class);

        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $entity = $service->execute(new AddBookDTO(
            'Title test',
            'Editora Abril',
            2,
            '2014',
            12.55,
            [$subject->id],
            [$author->id]
        ));

        $this->assertGreaterThan(0, $entity->id);
        $this->assertEquals('Title test', $entity->title);
        $this->assertEquals('Editora Abril', $entity->publisher);
        $this->assertEquals(2, $entity->edition);
        $this->assertEquals(2014, $entity->publication_year);
        $this->assertEquals(12.55, $entity->price);

        $this->assertEquals(1, $entity->authors()->count());
        $this->assertEquals($author->id, $entity->authors()->first()->id);

        $this->assertEquals(1, $entity->subjects()->count());
        $this->assertEquals($subject->id, $entity->subjects()->first()->id);
    }

    public function testForceRollback(): void
    {
        $service = $this->app->get(CreateBookService::class);

        $this->expectException(FailDuringPersistence::class);
        $service->execute(new AddBookDTO(
            'Title test 9857',
            'Editora Abril',
            2,
            '2014',
            12.55,
            [122222], // Nao existe, vai gerar um erro e cair no rollback
            []
        ));

        $this->assertNull(Book::where('title', 'Title test 9857')->first());
    }
}
