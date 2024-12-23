<?php

declare(strict_types=1);

namespace App\Services\Books\Subject;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Exceptions\ResourceDuplicated;
use App\Exceptions\ResourceNotFound;
use App\Models\Books\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UpdateSubjectService
{
    public function __construct(private readonly SubjectRepositoryInterface $subjectRepository)
    {
    }

    /**
     * @throws ResourceDuplicated
     * @throws ResourceNotFound
     */
    public function execute(AddSubjectDTO $input, int $id): Subject
    {
        $existent = $this->subjectRepository->findById($id);
        if (!$existent) {
            throw new ResourceNotFound();
        }

        $existentOtherWithSameDesc = $this->subjectRepository->existsWithDescription($input->description, $id);
        if ($existentOtherWithSameDesc instanceof Subject) {
            throw new ResourceDuplicated();
        }

        $subject = $this->subjectRepository->update($existent, $input);

        Log::info(
            "Subject was updated",
            [
            'subject' => $subject
            ]
        );

        return $subject;
    }
}
