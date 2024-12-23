<?php

declare(strict_types=1);

namespace App\Services\Books\Book;

use App\DTOs\Inputs\AddBookDTO;
use App\Exceptions\FailDuringPersistence;
use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Models\Books\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateBookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
    ) {
    }

    public function execute(AddBookDTO $input, int $id): Book
    {
        DB::beginTransaction();

        try {
            $book = $this->bookRepository->findById($id);
            if ($book === null) {
                throw new ResourceNotFound();
            }

            $existent = $this->bookRepository->existsWithTitle($input->title, $id);
            if ($existent !== null) {
                throw new ResourceDuplicated();
            }

            $this->bookRepository->update($book, $input);

            $this->handleRemovedRelations($book, $input);
            $this->handleAddedRelations($book, $input);

            DB::commit();

            Log::info(
                'Book was updated',
                [
                'book' => $book,
                ]
            );

            return $book;
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw new FailDuringPersistence($exception);
        }
    }

    private function handleRemovedRelations(Book $book, AddBookDTO $input): void
    {
        foreach ($book->authors as $author) {
            if (\in_array($author->id, $input->authors, true) === false) {
                $book->authors()->detach($author->id);
            }
        }

        foreach ($book->subjects as $subject) {
            if (\in_array($subject->id, $input->subjects, true) === false) {
                $book->subjects()->detach($subject->id);
            }
        }
    }

    private function handleAddedRelations(Book $book, AddBookDTO $input): void
    {
        foreach ($input->authors as $id) {
            if ($book->authors()->find($id)?->first() === null) {
                $book->authors()->attach($id);
            }
        }

        foreach ($input->subjects as $id) {
            if ($book->subjects()->find($id)?->first() === null) {
                $book->subjects()->attach($id);
            }
        }
    }
}
