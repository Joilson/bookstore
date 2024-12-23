<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Author;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Models\Books\Author;
use App\Services\Books\Author\UpdateAuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateAuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateEntity(): void
    {
        $service = $this->app->get(UpdateAuthorService::class);

        $author = Author::factory()->create();

        $updated = $service->execute(new AddAuthorDTO('Author Test 2'), $author->id);

        $this->assertEquals($author->id, $updated->id);
        $this->assertEquals('Author Test 2', $updated->name);
    }

    public function testShouldDenyUseSameNameOfOtherEntity(): void
    {
        $service = $this->app->get(UpdateAuthorService::class);

        $otherAuthor = Author::factory()->create(['name' => 'Author Test 4']);
        $author = Author::factory()->create();

        $this->expectException(ResourceDuplicated::class);
        $service->execute(new AddAuthorDTO('Author Test 4'), $author->id);
    }

    public function testShouldThrowErrorWhenEntityNotFound(): void
    {
        $service = $this->app->get(UpdateAuthorService::class);

        $this->expectException(ResourceNotFound::class);
        $service->execute(new AddAuthorDTO('Author Test 4'), 33333);
    }
}
