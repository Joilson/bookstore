<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\DTOs\Inputs\AuthUserDTO;
use App\Exceptions\UnauthorizedUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Services\Users\AuthenticateUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/auth',
    summary: 'Authenticate an already existent user and acquire token for usages in this project apis',
    tags: ['users']
)]
#[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AuthUserDTO'))]
#[OA\Response(
    response: 200,
    description: 'Success',
    content: new OA\JsonContent(ref: '#/components/schemas/AuthenticatedUserDTO')
)]
#[OA\Response(response: 422, description: 'Unprocessable Entity')]
class AuthController extends Controller
{
    public function __invoke(AuthUserRequest $request, AuthenticateUserService $authenticateUserService): JsonResponse
    {
        try {
            $out = $authenticateUserService->execute(AuthUserDTO::fromRequest($request));

            return response()->json($out);
        } catch (UnauthorizedUser $exception) {
            return response()->json(['error' => __('auth.failed')], 401);
        }
    }
}
