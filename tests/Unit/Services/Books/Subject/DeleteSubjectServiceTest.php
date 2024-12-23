<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Subject;

use App\Exceptions\ResourceNotFound;
use App\Models\Books\Subject;
use App\Services\Books\Subject\DeleteSubjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSubjectServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldDeleteAuthor(): void
    {
        $service = $this->app->get(DeleteSubjectService::class);

        $entity = Subject::factory()->create();

        $service->execute($entity->id);

        $this->assertNull(Subject::find($entity->id));
    }

    public function testShouldThrowErrorWhenNotFound(): void
    {
        $service = $this->app->get(DeleteSubjectService::class);

        $this->expectException(ResourceNotFound::class);
        $service->execute(44);
    }
}
