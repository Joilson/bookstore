<?php

declare(strict_types=1);

namespace App\Services\Books\Subject;

use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Support\Facades\Log;

class DeleteSubjectService
{
    public function __construct(private readonly SubjectRepositoryInterface $subjectRepository)
    {
    }

    /**
     * @throws ResourceDuplicated
     * @throws ResourceNotFound
     */
    public function execute(int $id): void
    {
        $existent = $this->subjectRepository->findById($id);
        if (!$existent) {
            throw new ResourceNotFound();
        }

        $this->subjectRepository->delete($existent);

        Log::info(
            "Subject was deleted",
            [
            'subject' => $existent
            ]
        );
    }
}
