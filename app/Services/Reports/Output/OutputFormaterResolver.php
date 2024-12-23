<?php

declare(strict_types=1);

namespace App\Services\Reports\Output;

use App\Services\Reports\Output\Formats\FormaterInterface;
use App\Services\Reports\OutputFormat;
use Illuminate\Contracts\Container\Container;

class OutputFormaterResolver
{
    /** @var iterable<FormaterInterface> */
    private iterable $formatters;

    public function __construct(private readonly Container $container)
    {
        $this->formatters = $this->container->tagged('report.formatters');
    }

    public function resolve(OutputFormat $format): FormaterInterface
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supports() === $format) {
                return $formatter;
            }
        }

        throw new \InvalidArgumentException("Formater of type {$format->value} not found");
    }
}
