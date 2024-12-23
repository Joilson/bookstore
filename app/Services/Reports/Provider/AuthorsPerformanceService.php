<?php

declare(strict_types=1);

namespace App\Services\Reports\Provider;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\Output\OutputFormaterResolver;
use App\Services\Reports\OutputFormat;
use Illuminate\Support\Facades\DB;

class AuthorsPerformanceService
{
    public function __construct(private readonly OutputFormaterResolver $formatResolver)
    {
    }

    public function execute(string $format): ReportDTO
    {
        $data = DB::select('SELECT * FROM authors_performance_report WHERE books_count >= 1');

        try {
            $formatObj = OutputFormat::from($format);
        } catch (\ValueError $exception) {
            throw new \InvalidArgumentException('Invalid report format. Try: [json, xml, csv, pdf]');
        }

        return $this->formatResolver->resolve($formatObj)->execute($data);
    }
}
