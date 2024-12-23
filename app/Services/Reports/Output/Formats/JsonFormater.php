<?php

declare(strict_types=1);

namespace App\Services\Reports\Output\Formats;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\OutputFormat;

class JsonFormater implements FormaterInterface
{
    public function execute(array $data): ReportDTO
    {
        return new ReportDTO(
            \json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
            ['Content-Type' => 'application/json'],
        );
    }

    public function supports(): OutputFormat
    {
        return OutputFormat::JSON;
    }
}
