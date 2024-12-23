<?php

declare(strict_types=1);

namespace App\Exceptions;

class UnauthorizedUser extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid credentials');
    }
}
