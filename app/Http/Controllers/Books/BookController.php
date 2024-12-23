<?php

declare(strict_types=1);

namespace App\Http\Controllers\Books;

use App\DTOs\Inputs\AddBookDTO;
use App\Exceptions\ResourceNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\Books\Book\CreateBookService;
use App\Services\Books\Book\DeleteBookService;
use App\Services\Books\Book\UpdateBookService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class BookController extends Controller
{
    #[OA\Post(path: '/api/books', summary: 'Add new book', security: [["BearerAuth" => []]], tags: ['books'])]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AddBookDTO'))]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'subject', ref: '#/components/schemas/Book', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function store(AddBookRequest $request, CreateBookService $createBookService): JsonResponse
    {
        $book = $createBookService->execute(AddBookDTO::fromRequest($request));

        return response()->json(['book' => new BookResource($book)], 201);
    }

    #[OA\Put(path: '/api/books/{id}', summary: 'Update book', security: [["BearerAuth" => []]], tags: ['books'])]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AddBookDTO'))]
    #[OA\PathParameter(name: 'id', description: 'Id of the book')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'subject', ref: '#/components/schemas/Book', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function update(int $id, UpdateBookRequest $request, UpdateBookService $updateBookService): JsonResponse
    {
        $book = $updateBookService->execute(AddBookDTO::fromRequest($request), $id);

        return response()->json(['book' => new BookResource($book)]);
    }

    #[OA\Get(path: '/api/books', summary: 'List books', security: [["BearerAuth" => []]], tags: ['books'])]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'data', ref: '#/components/schemas/Book', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function index(BookRepositoryInterface $bookRepository): JsonResponse
    {
        return response()->json(['data' => BookResource::collection($bookRepository->all())]);
    }

    #[OA\Delete(path: '/api/books', summary: 'Remove the book', security: [["BearerAuth" => []]], tags: ['books'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the book')]
    #[OA\Response(response: 200, description: 'Success',)]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function destroy(int $id, DeleteBookService $deleteBookService): JsonResponse
    {
        $deleteBookService->execute($id);

        return response()->json();
    }

    #[OA\Get(path: '/api/books/{id}', summary: 'Get book', security: [["BearerAuth" => []]], tags: ['books'])]
    #[OA\PathParameter(name: 'id', description: 'Id of the book')]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'subject', ref: '#/components/schemas/Book', type: 'object'),
            ]
        )
    )]
    #[OA\Response(response: 422, description: 'Unprocessable Entity')]
    public function show(int $id, BookRepositoryInterface $repository): JsonResponse
    {
        $entity = $repository->findById($id);
        if ($entity === null) {
            throw new ResourceNotFound();
        }

        return response()->json(['book' => new BookResource($entity)]);
    }
}
