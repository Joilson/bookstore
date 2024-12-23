<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

class ErrorHandler extends ExceptionHandler
{
    public function render($request, \Throwable $e)
    {
        if ($e instanceof ResourceDuplicated) {
            return response()->json(['error' => 'Already exists other register with some data'], 422);
        }

        if ($e instanceof ResourceNotFound) {
            return response()->json(['error' => 'Resource not found'], 400);
        }

        if ($e instanceof FailDuringPersistence) {
            Log::error('Fail during persistence', [
                    'exception' => $e,
                    'previous' => $e->getPrevious()
                ]);

            return response()->json(['error' => 'Fail during persistence'], 500);
        }

        return parent::render($request, $e);
    }
}
