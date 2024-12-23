<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\DTOs\Inputs\AddUserDTO;
use App\Models\Users\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected readonly User $model)
    {
    }

    public function add(AddUserDTO $input): User
    {
        $model = new User();
        $model->name = $input->name;
        $model->email = $input->email;
        $model->password = $input->password;

        $model->save();

        return $model;
    }
}
