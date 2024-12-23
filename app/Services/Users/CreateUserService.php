<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\DTOs\Inputs\AddUserDTO;
use App\Models\Users\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CreateUserService
{
    public function __construct(
        public readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(AddUserDTO $input): User
    {
        $user = $this->userRepository->add($input);

        Log::info('New user was created', ['user' => $user]);

        return $user;
    }
}
