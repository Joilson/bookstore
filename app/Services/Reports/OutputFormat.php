<?php

declare(strict_types=1);

namespace App\Services\Reports;

enum OutputFormat: string
{
    case JSON = 'json';
    case CSV = 'csv';
    case XML = 'xml';
    case PDF = 'pdf';
}
