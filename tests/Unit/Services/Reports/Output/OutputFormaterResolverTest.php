<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Output;

use App\Services\Reports\Output\Formats\CsvFormater;
use App\Services\Reports\Output\Formats\JsonFormater;
use App\Services\Reports\Output\Formats\PdfFormater;
use App\Services\Reports\Output\Formats\XmlFormater;
use App\Services\Reports\Output\OutputFormaterResolver;
use App\Services\Reports\OutputFormat;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OutputFormaterResolverTest extends TestCase
{
    #[DataProvider('formatsDataProvider')]
    public function testShouldReturnsCorrectlyFormater(OutputFormat $format, string $expectedFormatterClass): void
    {
        $formatter = $this->app->get(OutputFormaterResolver::class)->resolve($format);

        $this->assertInstanceOf($expectedFormatterClass, $formatter);
    }

    public static function formatsDataProvider(): array
    {
        return [
            'json' => [OutputFormat::JSON, JsonFormater::class],
            'xml' => [OutputFormat::XML, XmlFormater::class],
            'csv' => [OutputFormat::CSV, CsvFormater::class],
            'pdf' => [OutputFormat::PDF, PdfFormater::class],
        ];
    }
}
