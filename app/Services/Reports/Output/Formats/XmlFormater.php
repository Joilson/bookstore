<?php

declare(strict_types=1);

namespace App\Services\Reports\Output\Formats;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\OutputFormat;

class XmlFormater implements FormaterInterface
{
    public function execute(array $data): ReportDTO
    {
        $xml = new \SimpleXMLElement('<root/>');
        foreach ($data as $item) {
            $entry = $xml->addChild('entry');
            if ($entry === null) {
                continue;
            }
            foreach ($item as $key => $value) {
                $entry->addChild($key, htmlspecialchars((string)$value));
            }
        }

        return new ReportDTO(
            $xml->asXML(),
            [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="report.xml"',
            ],
        );
    }

    public function supports(): OutputFormat
    {
        return OutputFormat::XML;
    }
}
