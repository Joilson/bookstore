<?php

declare(strict_types=1);

namespace App\Services\Books\Author;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Models\Books\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UpdateAuthorService
{
    public function __construct(private readonly AuthorRepositoryInterface $authorRepository)
    {
    }

    /**
     * @throws ResourceDuplicated
     * @throws ResourceNotFound
     */
    public function execute(AddAuthorDTO $input, int $id): Author
    {
        $existent = $this->authorRepository->findById($id);
        if (!$existent) {
            throw new ResourceNotFound();
        }

        $existentOtherWithSameName = $this->authorRepository->existsWithName($input->name, $id);
        if ($existentOtherWithSameName instanceof Author) {
            throw new ResourceDuplicated();
        }

        $author = $this->authorRepository->update($existent, $input);

        Log::info(
            "Author was updated",
            [
            'author' => $author
            ]
        );

        return $author;
    }
}
