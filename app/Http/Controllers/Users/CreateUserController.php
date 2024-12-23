<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\DTOs\Inputs\AddUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Services\Users\CreateUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/user',
    summary: 'Create user for interacts with this project',
    tags: ['users']
)]
#[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AddUserDTO'))]
#[OA\Response(
    response: 200,
    description: 'Success',
    content: new OA\JsonContent(
        properties: [
        new OA\Property(
            property: 'user',
            properties: [
            new OA\Property(property: 'name', type: 'string'),
            new OA\Property(property: 'email', type: 'string'),
            new OA\Property(property: 'updated_at', type: 'datetime'),
            new OA\Property(property: 'created_at', type: 'datetime'),
            new OA\Property(property: 'id', type: 'integer'),
            ],
            type: 'object'
        ),
        ]
    )
)]
#[OA\Response(response: 422, description: 'Unprocessable Entity')]
class CreateUserController extends Controller
{
    public function __invoke(
        AddUserRequest $request,
        CreateUserService $createUser
    ): JsonResponse {
        return response()->json(
            [
            'user' => $createUser->execute(AddUserDTO::fromRequest($request))
            ],
            201
        );
    }
}
