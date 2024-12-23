<?php

declare(strict_types=1);

namespace App\Exceptions;

class ResourceDuplicated extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Resource duplicated');
    }
}
