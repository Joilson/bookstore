<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Output\Formats;

use App\Services\Reports\Output\Formats\PdfFormater;
use App\Services\Reports\Output\Formats\XmlFormater;
use App\Services\Reports\OutputFormat;
use Tests\TestCase;
use Smalot\PdfParser\Parser;

class PdfFormaterTest extends TestCase
{
    use HasReportTestData;

    public function testShouldAssertOutput(): void
    {
        $formatter = $this->app->get(PdfFormater::class);

        $this->assertInstanceOf(PdfFormater::class, $formatter);
        $this->assertEquals(OutputFormat::PDF, $formatter->supports());

        $out = $formatter->execute($this->getData());

        $this->assertEquals([
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="report.pdf"'
        ], $out->headers);

        $parser = new Parser();
        $pdf = $parser->parseContent($out->content);

        $this->assertEquals(
            \trim(\file_get_contents(__DIR__ . "/Fixture/out_pdf.txt")), $pdf->getText()
        );
    }
}
