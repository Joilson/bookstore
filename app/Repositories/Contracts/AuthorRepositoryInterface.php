<?php

namespace App\Repositories\Contracts;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Models\Books\Author;
use Illuminate\Database\Eloquent\Collection;

interface AuthorRepositoryInterface
{
    public function create(AddAuthorDTO $input): Author;

    public function update(Author $author, AddAuthorDTO $input): Author;

    public function findById(int $id): ?Author;

    public function existsWithName(string $name, int $id): ?Author;

    /**
     * @return Collection<Author>
     */
    public function all(): Collection;

    public function delete(Author $author): void;
}
