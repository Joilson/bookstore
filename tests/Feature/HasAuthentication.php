<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DTOs\Inputs\AuthUserDTO;
use App\Models\Users\User;
use App\Services\Users\AuthenticateUserService;

trait HasAuthentication
{
    public function auth(): string
    {
        $user = User::factory()->create(['password' => 'password123']);

        $service = app(AuthenticateUserService::class);
        $out = $service->execute(new AuthUserDTO($user->email, 'password123'));

        return "Bearer {$out->token}";
    }
}
