<?php

namespace App\Repositories\Contracts;

use App\DTOs\Inputs\AddBookDTO;
use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Subject;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function create(AddBookDTO $input): Book;

    public function update(Book $book, AddBookDTO $input): Book;

    public function findById(int $id): ?Book;

    public function existsWithTitle(string $title, int $id): ?Book;

    /**
     * @return Collection<Book>
     */
    public function all(): Collection;

    public function delete(Book $author): void;
}
