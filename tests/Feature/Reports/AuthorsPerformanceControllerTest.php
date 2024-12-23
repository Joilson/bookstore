<?php

declare(strict_types=1);

namespace Tests\Feature\Reports;

use Tests\TestCase;

class AuthorsPerformanceControllerTest extends TestCase
{
    public function testReportGeneration(): void
    {
        $response = $this->get('/report/author-performance.json');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }
}
