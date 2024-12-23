<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\DTOs\Inputs\AuthUserDTO;
use App\DTOs\Outputs\AuthenticatedUserDTO;
use App\Exceptions\UnauthorizedUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateUserService
{
    /**
     * @throws UnauthorizedUser
     */
    public function execute(AuthUserDTO $input, int $expiration = 43200): AuthenticatedUserDTO
    {
        if (!$token = JWTAuth::attempt($input->jsonSerialize())) {
            throw new UnauthorizedUser();
        }

        return new AuthenticatedUserDTO(
            $token,
            auth('api')->factory()->getTTL() * $expiration
        );
    }
}
