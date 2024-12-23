<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Models\Books\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function __construct(protected readonly Subject $model)
    {
    }

    public function create(AddSubjectDTO $input): Subject
    {
        $model = new Subject();
        $model->description = $input->description;
        $model->save();

        return $model;
    }

    public function update(Subject $subject, AddSubjectDTO $input): Subject
    {
        $subject->description = $input->description;
        $subject->update();

        return $subject;
    }

    public function findById(int $id): ?Subject
    {
        return $this->model->query()->find($id);
    }

    public function existsWithDescription(string $description, int $id): ?Subject
    {
        return $this->model
                    ->query()
                    ->where('description', $description)
                    ->where('id', '!=', $id)
                    ->first();
    }

    public function all(): Collection
    {
        return $this->model->query()->get();
    }

    public function delete(Subject $author): void
    {
        $author->delete();
    }
}
