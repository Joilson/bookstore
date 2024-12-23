<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Author;

use App\Exceptions\ResourceNotFound;
use App\Models\Books\Author;
use App\Services\Books\Author\DeleteAuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldDeleteAuthor(): void
    {
        $service = $this->app->get(DeleteAuthorService::class);

        $author = Author::factory()->create();

        $service->execute($author->id);

        $this->assertNull(Author::find($author->id));
    }

    public function testShouldThrowErrorWhenNotFound(): void
    {
        $service = $this->app->get(DeleteAuthorService::class);

        $this->expectException(ResourceNotFound::class);
        $service->execute(44);
    }
}
