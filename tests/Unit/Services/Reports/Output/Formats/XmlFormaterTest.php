<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Output\Formats;

use App\Services\Reports\Output\Formats\XmlFormater;
use App\Services\Reports\OutputFormat;
use Tests\TestCase;

class XmlFormaterTest extends TestCase
{
    use HasReportTestData;

    public function testShouldAssertOutput(): void
    {
        $formatter = $this->app->get(XmlFormater::class);

        $this->assertInstanceOf(XmlFormater::class, $formatter);
        $this->assertEquals(OutputFormat::XML, $formatter->supports());

        $out = $formatter->execute($this->getData());

        $this->assertEquals([
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="report.xml"'
        ], $out->headers);

        $this->assertStringEqualsFile(
            __DIR__ . "/Fixture/out.xml", $out->content
        );
    }
}
