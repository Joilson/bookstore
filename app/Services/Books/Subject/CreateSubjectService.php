<?php

declare(strict_types=1);

namespace App\Services\Books\Subject;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Models\Books\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CreateSubjectService
{
    public function __construct(private readonly SubjectRepositoryInterface $subjectRepository)
    {
    }

    public function execute(AddSubjectDTO $input): Subject
    {
        $subject = $this->subjectRepository->create($input);

        Log::info(
            "New subject was added",
            [
            'subject' => $subject
            ]
        );

        return $subject;
    }
}
