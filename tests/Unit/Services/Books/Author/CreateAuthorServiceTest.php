<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Author;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Services\Books\Author\CreateAuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateAuthor(): void
    {
        $service = $this->app->get(CreateAuthorService::class);

        $author = $service->execute(new AddAuthorDTO('Author Test'));

        $this->assertGreaterThan(0, $author->id);
        $this->assertEquals('Author Test', $author->name);
    }
}
