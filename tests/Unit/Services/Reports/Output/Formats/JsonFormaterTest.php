<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Output\Formats;

use App\Services\Reports\Output\Formats\JsonFormater;
use App\Services\Reports\OutputFormat;
use Tests\TestCase;

class JsonFormaterTest extends TestCase
{
    use HasReportTestData;

    public function testShouldAssertOutput(): void
    {
        $formatter = $this->app->get(JsonFormater::class);

        $this->assertInstanceOf(JsonFormater::class, $formatter);
        $this->assertEquals(OutputFormat::JSON, $formatter->supports());

        $out = $formatter->execute($this->getData());

        $this->assertEquals(['Content-Type' => 'application/json'], $out->headers);
        $this->assertEquals(
            \trim(\file_get_contents(__DIR__ . "/Fixture/out.json")),
            $out->content
        );
    }
}
