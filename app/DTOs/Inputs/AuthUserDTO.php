<?php

declare(strict_types=1);

namespace App\DTOs\Inputs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AuthUserDTO')]
readonly class AuthUserDTO implements InputDTOInterface, \JsonSerializable
{
    public function __construct(
        #[OA\Property] public string $email,
        #[OA\Property] public string $password
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->validated();

        return new self($data['email'], $data['password']);
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
