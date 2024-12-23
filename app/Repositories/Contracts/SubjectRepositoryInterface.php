<?php

namespace App\Repositories\Contracts;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Models\Books\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectRepositoryInterface
{
    public function create(AddSubjectDTO $input): Subject;

    public function update(Subject $subject, AddSubjectDTO $input): Subject;

    public function findById(int $id): ?Subject;

    public function existsWithDescription(string $description, int $id): ?Subject;

    /**
     * @return Collection<Subject>
     */
    public function all(): Collection;

    public function delete(Subject $author): void;
}
