<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\DTOs\Inputs\AddBookDTO;
use App\Models\Books\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function __construct(protected readonly Book $model)
    {
    }

    public function create(AddBookDTO $input): Book
    {
        $model = new Book();
        $model->title = $input->title;
        $model->publisher = $input->publisher;
        $model->edition = $input->edition;
        $model->publication_year = $input->publicationYear;
        $model->price = $input->price;

        $model->save();

        return $model;
    }

    public function update(Book $book, AddBookDTO $input): Book
    {
        $book->title = $input->title;
        $book->publisher = $input->publisher;
        $book->edition = $input->edition;
        $book->publication_year = $input->publicationYear;
        $book->price = $input->price;

        $book->save();

        return $book;
    }

    public function findById(int $id): ?Book
    {
        return $this->model->query()->find($id);
    }

    public function existsWithTitle(string $title, int $id): ?Book
    {
        return $this->model
            ->query()
            ->where('title', $title)
            ->where('id', '!=', $id)
            ->first();
    }

    public function all(): Collection
    {
        return $this->model->query()->get();
    }

    public function delete(Book $author): void
    {
        $author->delete();
    }
}
