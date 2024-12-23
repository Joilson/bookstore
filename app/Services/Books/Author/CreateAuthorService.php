<?php

declare(strict_types=1);

namespace App\Services\Books\Author;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Models\Books\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CreateAuthorService
{
    public function __construct(private readonly AuthorRepositoryInterface $authorRepository)
    {
    }

    public function execute(AddAuthorDTO $input): Author
    {
        $author = $this->authorRepository->create($input);

        Log::info(
            "New author was added",
            [
            'author' => $author
            ]
        );

        return $author;
    }
}
