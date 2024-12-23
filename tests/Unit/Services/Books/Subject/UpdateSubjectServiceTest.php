<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Books\Subject;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Models\Books\Subject;
use App\Services\Books\Subject\UpdateSubjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSubjectServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateEntity(): void
    {
        $service = $this->app->get(UpdateSubjectService::class);

        $subject = Subject::factory()->create();

        $updated = $service->execute(new AddSubjectDTO('description test 2'), $subject->id);

        $this->assertEquals($subject->id, $updated->id);
        $this->assertEquals('description test 2', $updated->description);
    }

    public function testShouldDenyUseSameNameOfOtherEntity(): void
    {
        $service = $this->app->get(UpdateSubjectService::class);

        $other = Subject::factory()->create(['description' => 'description test']);
        $entity = Subject::factory()->create();

        $this->expectException(ResourceDuplicated::class);
        $service->execute(new AddSubjectDTO('description test'), $entity->id);
    }

    public function testShouldThrowErrorWhenEntityNotFound(): void
    {
        $service = $this->app->get(UpdateSubjectService::class);

        $this->expectException(ResourceNotFound::class);
        $service->execute(new AddSubjectDTO('test desc 1'), 33333);
    }
}
