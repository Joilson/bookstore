<?php

declare(strict_types=1);

namespace App\Services\Books\Book;

use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Support\Facades\Log;

class DeleteBookService
{
    public function __construct(private readonly BookRepositoryInterface $bookRepository)
    {
    }

    /**
     * @throws ResourceDuplicated
     * @throws ResourceNotFound
     */
    public function execute(int $id): void
    {
        $existent = $this->bookRepository->findById($id);
        if (!$existent) {
            throw new ResourceNotFound();
        }

        $this->bookRepository->delete($existent);

        Log::info(
            "Book was deleted",
            [
            'subject' => $existent
            ]
        );
    }
}
