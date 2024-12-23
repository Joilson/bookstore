<?php

declare(strict_types=1);

namespace App\DTOs\Inputs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'AddBookDTO')]
readonly class AddBookDTO implements InputDTOInterface
{
    public function __construct(
        #[OA\Property] public string $title,
        #[OA\Property] public string $publisher,
        #[OA\Property] public int $edition,
        #[OA\Property] public string $publicationYear,
        #[OA\Property] public float $price,
        #[OA\Property(items: new OA\Items(type: 'integer'))] public array $subjects,
        #[OA\Property(items: new OA\Items(type: 'integer'))]public array $authors,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->validated();

        return new self(
            $data['title'],
            $data['publisher'],
            $data['edition'],
            $data['publicationYear'],
            $data['price'],
            $data['subjects'],
            $data['authors'],
        );
    }
}
