<?php

declare(strict_types=1);

namespace App\DTOs\Outputs;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AuthenticatedUserDTO')]
readonly class AuthenticatedUserDTO implements \JsonSerializable
{
    public function __construct(
        #[OA\Property] public string $token,
        #[OA\Property] public int $expiresIn,
        #[OA\Property] public string $type = "bearer",
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'type' => $this->type,
            'expiresIn' => $this->expiresIn,
        ];
    }
}
