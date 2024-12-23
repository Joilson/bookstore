<?php

declare(strict_types=1);

namespace App\Services\Reports\Output\Formats;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\OutputFormat;
use Illuminate\Support\Facades\App;

class PdfFormater implements FormaterInterface
{
    public function execute(array $data): ReportDTO
    {
        $pdf = App::make('dompdf.wrapper');

        $pdf = $pdf->loadView('pdf.template', ['data' => $data])->output();

        return new ReportDTO(
            $pdf,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="report.pdf"',
            ],
        );
    }

    public function supports(): OutputFormat
    {
        return OutputFormat::PDF;
    }
}
