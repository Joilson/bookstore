<?php

declare(strict_types=1);

namespace App\DTOs\Inputs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AddUserDTO')]
class AddUserDTO implements InputDTOInterface
{
    public function __construct(
        #[OA\Property] public readonly string $name,
        #[OA\Property] public readonly string $email,
        #[OA\Property] public readonly string $password
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->validated();

        return new self($data['name'], $data['email'], bcrypt($data['password']));
    }
}
