<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reports\Output\Formats;

trait HasReportTestData
{
    public function getData(): array
    {
        return [
            [
                "name" => "Author 1",
                "subjects_count" => 1,
                "books_count" => 1,
                "publisher_count" => 1,
                "first_publication" => "2024-12-22 01:36:29",
                "last_publication" => "2024-12-22 01:36:29",
                "most_expensive_price" => "25.50",
                "cheapest_price" => "125.32",
                "book_titles" => "Book title 1"
            ]
        ];
    }
}
