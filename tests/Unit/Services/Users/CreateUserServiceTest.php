<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\DTOs\Inputs\AddUserDTO;
use App\Services\Users\CreateUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateEntity(): void
    {
        $service = $this->app->get(CreateUserService::class);

        $entity = $service->execute(new AddUserDTO(
            'Author Test',
            'test@test.com',
            '123123123',
        ));

        $this->assertGreaterThan(0, $entity->id);
        $this->assertEquals('Author Test', $entity->name);
        $this->assertEquals('test@test.com', $entity->email);
        $this->assertIsString($entity->password);
    }
}
