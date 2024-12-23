<?php

declare(strict_types=1);

namespace App\DTOs\Inputs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AddSubjectDTO')]
readonly class AddSubjectDTO implements InputDTOInterface
{
    public function __construct(
        #[OA\Property] public string $description,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->validated();

        return new self($data['description']);
    }
}
