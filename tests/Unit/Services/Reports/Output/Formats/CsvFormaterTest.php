<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Output\Formats;

use App\Services\Reports\Output\Formats\CsvFormater;
use App\Services\Reports\OutputFormat;
use Tests\TestCase;

class CsvFormaterTest extends TestCase
{
    use HasReportTestData;

    public function testShouldAssertOutput(): void
    {
        $formatter = $this->app->get(CsvFormater::class);

        $this->assertInstanceOf(CsvFormater::class, $formatter);
        $this->assertEquals(OutputFormat::CSV, $formatter->supports());

        $out = $formatter->execute($this->getData());

        $this->assertEquals([
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="report.csv"'
        ], $out->headers);

        $this->assertStringEqualsFile(
            __DIR__ . "/Fixture/out.csv", $out->content
        );
    }
}
