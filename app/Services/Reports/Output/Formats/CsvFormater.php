<?php

declare(strict_types=1);

namespace App\Services\Reports\Output\Formats;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\OutputFormat;

class CsvFormater implements FormaterInterface
{
    public function execute(array $data): ReportDTO
    {
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, array_keys((array)$data[0]));
        foreach ($data as $row) {
            fputcsv($handle, (array)$row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return new ReportDTO(
            $csv,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="report.csv"',
            ],
        );
    }

    public function supports(): OutputFormat
    {
        return OutputFormat::CSV;
    }
}
