<?php

declare(strict_types=1);

namespace App\Services\Books\Author;

use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Log;

class DeleteAuthorService
{
    public function __construct(private readonly AuthorRepositoryInterface $authorRepository)
    {
    }

    /**
     * @throws ResourceDuplicated
     * @throws ResourceNotFound
     */
    public function execute(int $id): void
    {
        $existent = $this->authorRepository->findById($id);
        if (!$existent) {
            throw new ResourceNotFound();
        }

        $this->authorRepository->delete($existent);

        Log::info(
            "Author was deleted",
            [
            'author' => $existent
            ]
        );
    }
}
