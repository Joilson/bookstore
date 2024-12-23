<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Models\Books\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(protected readonly Author $model)
    {
    }

    public function create(AddAuthorDTO $input): Author
    {
        $model = new Author();
        $model->name = $input->name;
        $model->save();

        return $model;
    }

    public function update(Author $author, AddAuthorDTO $input): Author
    {
        $author->name = $input->name;
        $author->update();

        return $author;
    }

    public function findById(int $id): ?Author
    {
        return $this->model->query()->find($id);
    }

    public function existsWithName(string $name, int $id): ?Author
    {
        return $this->model
            ->query()
            ->where('name', $name)
            ->where('id', '!=', $id)
            ->first();
    }

    public function all(): Collection
    {
        return $this->model->query()->get();
    }

    public function delete(Author $author): void
    {
        $author->delete();
    }
}
