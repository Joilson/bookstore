<?php

declare(strict_types=1);

namespace App\DTOs\Outputs;

class ReportDTO
{
    public function __construct(
        public mixed $content,
        public array $headers,
    ) {
    }
}
