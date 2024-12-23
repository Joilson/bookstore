<?php

declare(strict_types=1);

namespace App\Http\Controllers\Books;

use App\DTOs\Inputs\AddAuthorDTO;
use App\Exceptions\ResourceNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Services\Books\Author\CreateAuthorService;
use App\Services\Books\Author\DeleteAuthorService;
use App\Services\Books\Author\UpdateAuthorService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthorController extends Controller
{
    #[OA\Post(path: '/api/authors', summary: 'Add new Author', security: [["BearerAuth" => []]], tags: ['authors'])]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AddAuthorDTO'))]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'author', ref: '#/components/schemas/Author', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function store(AddAuthorRequest $request, CreateAuthorService $createAuthorService): JsonResponse
    {
        $author = $createAuthorService->execute(AddAuthorDTO::fromRequest($request));

        return response()->json(['author' => $author], 201);
    }

    #[OA\Put(path: '/api/authors/{id}', summary: 'Update Author', security: [["BearerAuth" => []]], tags: ['authors'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the author')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'author', ref: '#/components/schemas/Author', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function update(
        int $id,
        UpdateAuthorRequest $request,
        UpdateAuthorService $updateAuthorService
    ): JsonResponse {
        /**
         * Aqui eu uso o mesmo DTO, porem o request e diferente por conta da validaçao.
         */
        $author = $updateAuthorService->execute(AddAuthorDTO::fromRequest($request), $id);

        return response()->json(['author' => $author]);
    }

    #[OA\Get(path: '/api/authors', summary: 'List all Authors', security: [["BearerAuth" => []]], tags: ['authors'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the author')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Author', type: 'object')
                ),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    #[OA\Response(response: 400, description: 'Resource not found')]
    public function index(AuthorRepositoryInterface $authorRepository): JsonResponse
    {
        return response()->json(['data' => $authorRepository->all()]);
    }

    #[OA\Delete(
        path: '/api/authors/{id}',
        summary: 'Delete Author',
        security: [["BearerAuth" => []]],
        tags: ['authors']
    )]
    #[OA\PathParameter(name: 'id', description: 'Id of the author')]
    #[OA\Response(response: 200, description: 'Success',)]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    #[OA\Response(response: 400, description: 'Resource not found')]
    public function destroy(int $id, DeleteAuthorService $deleteAuthorService): JsonResponse
    {
        $deleteAuthorService->execute($id);

        return response()->json();
    }

    #[OA\Get(path: '/api/authors/{id}', summary: 'Get Author', security: [["BearerAuth" => []]], tags: ['authors'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the author')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'author', ref: '#/components/schemas/Author', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function show(int $id, AuthorRepositoryInterface $repository): JsonResponse
    {
        $entity = $repository->findById($id);
        if ($entity === null) {
            throw new ResourceNotFound();
        }

        return response()->json(['author' => $entity]);
    }
}
