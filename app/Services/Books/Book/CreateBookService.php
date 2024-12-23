<?php

declare(strict_types=1);

namespace App\Services\Books\Book;

use App\DTOs\Inputs\AddBookDTO;
use App\Exceptions\FailDuringPersistence;
use App\Models\Books\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateBookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository
    ) {
    }

    /**
     * @throws FailDuringPersistence
     */
    public function execute(AddBookDTO $input): Book
    {
        DB::beginTransaction();

        try {
            $book = $this->bookRepository->create($input);

            foreach ($input->authors as $id) {
                $book->authors()->attach($id);
            }

            foreach ($input->subjects as $id) {
                $book->subjects()->attach($id);
            }

            DB::commit();

            Log::info(
                'Book was created',
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
}
