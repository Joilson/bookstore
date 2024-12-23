<?php

declare(strict_types=1);

namespace App\Exceptions;

class FailDuringPersistence extends \RuntimeException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Fail during database persistence', 0, $previous);
    }
}
