<?php

declare(strict_types=1);

namespace App\Http\Controllers\Books;

use App\DTOs\Inputs\AddSubjectDTO;
use App\Exceptions\ResourceNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Services\Books\Subject\CreateSubjectService;
use App\Services\Books\Subject\DeleteSubjectService;
use App\Services\Books\Subject\UpdateSubjectService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class SubjectController extends Controller
{
    #[OA\Post(path: '/api/subjects', summary: 'Add new Subject', security: [["BearerAuth" => []]], tags: ['subjects'])]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AddSubjectDTO'))]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
            new OA\Property(property: 'subject', ref: '#/components/schemas/Subject', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function store(AddSubjectRequest $request, CreateSubjectService $createSubjectService): JsonResponse
    {
        $subject = $createSubjectService->execute(AddSubjectDTO::fromRequest($request));

        return response()->json(['subject' => $subject], 201);
    }

    #[OA\Put(
        path: '/api/subjects/{id}',
        summary: 'Update Subject',
        security: [["BearerAuth" => []]],
        tags: ['subjects']
    )]
    #[OA\PathParameter(name: 'id', description: 'Id of the subject')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
            new OA\Property(property: 'subject', ref: '#/components/schemas/Subject', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function update(
        int $id,
        UpdateSubjectRequest $request,
        UpdateSubjectService $updateSubjectService
    ): JsonResponse {
        /**
         * Aqui eu uso o mesmo DTO, porem o request e diferente por conta da validaçao.
         */
        $subject = $updateSubjectService->execute(AddSubjectDTO::fromRequest($request), $id);

        return response()->json(['subject' => $subject]);
    }

    #[OA\Get(path: '/api/subjects', summary: 'List all Subjects', security: [["BearerAuth" => []]], tags: ['subjects'])]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
            new OA\Property(
                property: 'data',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/Subject', type: 'object')
            ),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    #[OA\Response(response: 400, description: 'Resource not found')]
    public function index(SubjectRepositoryInterface $subjectRepository): JsonResponse
    {
        return response()->json(['data' => $subjectRepository->all()]);
    }

    #[OA\Delete(path: '/api/subjects/{id}', summary: 'Delete Subject', security: [["BearerAuth" => []]], tags: ['subjects'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the subject')]
    #[OA\Response(response: 200, description: 'Success',)]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    #[OA\Response(response: 400, description: 'Resource not found')]
    public function destroy(int $id, DeleteSubjectService $deleteSubjectService): JsonResponse
    {
        $deleteSubjectService->execute($id);

        return response()->json();
    }

    #[OA\Get(path: '/api/subjects/{id}', summary: 'Get Subject', security: [["BearerAuth" => []]], tags: ['subjects'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the subject')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
            new OA\Property(property: 'subject', ref: '#/components/schemas/Subject', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function show(int $id, SubjectRepositoryInterface $repository): JsonResponse
    {
        $entity = $repository->findById($id);
        if ($entity === null) {
            throw new ResourceNotFound();
        }

        return response()->json(['subject' => $entity]);
    }
}
