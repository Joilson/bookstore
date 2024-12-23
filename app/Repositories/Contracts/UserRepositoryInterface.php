<?php

namespace App\Repositories\Contracts;

use App\DTOs\Inputs\AddUserDTO;
use App\Models\Users\User;

interface UserRepositoryInterface
{
    public function add(AddUserDTO $input): User;
}
