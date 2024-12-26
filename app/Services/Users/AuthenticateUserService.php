<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\DTOs\Inputs\AuthUserDTO;
use App\DTOs\Outputs\AuthenticatedUserDTO;
use App\Exceptions\UnauthorizedUser;

class AuthenticateUserService
{
    /**
     * @throws UnauthorizedUser
     */
    public function execute(AuthUserDTO $input): AuthenticatedUserDTO
    {
        $credentials = [
            "email" => $input->email,
            "password" => $input->password
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            throw new UnauthorizedUser();
        }

        return new AuthenticatedUserDTO((string)$token);
    }
}
