<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\Provider\AuthorsPerformanceService;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AuthorsPerformanceController extends Controller
{
    #[OA\Get(path: '/report/author-performance.{format}', summary: 'download report', tags: ['reports'])]
    #[OA\Response(response: 200, description: 'report content')]
    public function __invoke(string $format, AuthorsPerformanceService $service): Response
    {
        $output = $service->execute($format);

        return response($output->content, 200, $output->headers);
    }
}
