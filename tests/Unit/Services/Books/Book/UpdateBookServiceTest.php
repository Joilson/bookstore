<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Book;

use App\DTOs\Inputs\AddBookDTO;
use App\Exceptions\FailDuringPersistence;
use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Subject;
use App\Services\Books\Book\UpdateBookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateBookServiceTest extends TestCase
{
    use RefreshDatabase;

    private readonly AddBookDTO $inupt;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inupt = new AddBookDTO(
            'Title test 9857',
            'Editora Abril',
            2,
            '2014',
            12.55,
            [],
            []
        );
    }

    public function testUpdateEntity(): void
    {
        $service = $this->app->get(UpdateBookService::class);
        $entity = Book::factory()->create();

        $updated = $service->execute($this->inupt, $entity->id);

        $this->assertEquals($entity->id, $updated->id);
        $this->assertEquals('Title test 9857', $updated->title);
        $this->assertEquals('Editora Abril', $updated->publisher);
        $this->assertEquals(2, $updated->edition);
        $this->assertEquals(2014, $updated->publication_year);
        $this->assertEquals(12.55, $updated->price);
    }

    public function testShouldDenyUseSameTitleOfOtherEntity(): void
    {
        $service = $this->app->get(UpdateBookService::class);

        $other = Book::factory()->create(['title' => $this->inupt->title]);
        $entity = Book::factory()->create();

        $this->expectException(FailDuringPersistence::class);
        $service->execute($this->inupt, $entity->id);
    }

    public function testShouldThrowErrorWhenEntityNotFound(): void
    {
        $service = $this->app->get(UpdateBookService::class);

        $this->expectException(FailDuringPersistence::class);
        $service->execute($this->inupt, 33333);
    }

    public function testShouldRemoveDeletedRelations(): void
    {
        $service = $this->app->get(UpdateBookService::class);
        $entity = Book::factory()->create();

        $updated = $service->execute($this->inupt, $entity->id);

        $this->assertEquals(0, $updated->authors()->count());
        $this->assertEquals(0, $updated->subjects()->count());
    }

    public function testShouldAddRelations(): void
    {
        $service = $this->app->get(UpdateBookService::class);
        $entity = Book::factory()->create();

        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $updated = $service->execute(new AddBookDTO(
            'Title test 9857',
            'Editora Abril',
            2,
            '2014',
            12.55,
            [$entity->subjects()->first()->id, $subject->id],
            [$entity->authors()->first()->id, $author->id],
        ), $entity->id);

        $this->assertEquals(2, $updated->authors()->count());
        $this->assertEquals(2, $updated->subjects()->count());
    }
}
