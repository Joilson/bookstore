<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\DTOs\Inputs\AuthUserDTO;
use App\Exceptions\UnauthorizedUser;
use App\Models\Users\User;
use App\Services\Users\AuthenticateUserService;
use Tests\TestCase;

class AuthenticateUserServiceTest extends TestCase
{
    public function testShouldAuthenticateForCorrectlyToken(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $service = app(AuthenticateUserService::class);

        $out = $service->execute(new AuthUserDTO($user->email, 'password123'));

        $this->assertIsString($out->token);
        $this->assertEquals(60, $out->expiresIn);
        $this->assertEquals('bearer', $out->type);
    }

    public function testShouldDenyForInvalidUser(): void
    {
        $service = app(AuthenticateUserService::class);

        $this->expectException(UnauthorizedUser::class);
        $service->execute(new AuthUserDTO('invalid@user.com', 'password123'));
    }
}
