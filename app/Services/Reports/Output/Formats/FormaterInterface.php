<?php

namespace App\Services\Reports\Output\Formats;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\OutputFormat;

interface FormaterInterface
{
    public function execute(array $data): ReportDTO;

    public function supports(): OutputFormat;
}
