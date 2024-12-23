<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Provider;

use App\DTOs\Outputs\ReportDTO;
use App\Services\Reports\Provider\AuthorsPerformanceService;
use Tests\TestCase;

class AuthorsPerformanceServiceTest extends TestCase
{
    public function testIdentifyFormatAndReturnCorrectlyOutput(): void
    {
        $service = $this->app->get(AuthorsPerformanceService::class);

        $out = $service->execute('json');

        $this->assertInstanceOf(ReportDTO::class, $out);
    }
}
