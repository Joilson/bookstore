<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Subject;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Services\Books\Subject\CreateSubjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSubjectServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateEntity(): void
    {
        $service = $this->app->get(CreateSubjectService::class);

        $entity = $service->execute(new AddSubjectDTO('Subject test'));

        $this->assertGreaterThan(0, $entity->id);
        $this->assertEquals('Subject test', $entity->description);
    }
}
