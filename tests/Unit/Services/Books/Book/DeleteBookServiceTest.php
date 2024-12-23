<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Book;

use App\Exceptions\ResourceNotFound;
use App\Models\Books\Book;
use App\Models\Books\Subject;
use App\Services\Books\Book\DeleteBookService;
use App\Services\Books\Subject\DeleteSubjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteBookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldDeleteAuthor(): void
    {
        $service = $this->app->get(DeleteBookService::class);

        $entity = Book::factory()->create();

        $service->execute($entity->id);

        $this->assertNull(Book::find($entity->id));
    }

    public function testShouldThrowErrorWhenNotFound(): void
    {
        $service = $this->app->get(DeleteBookService::class);

        $this->expectException(ResourceNotFound::class);
        $service->execute(44);
    }
}
