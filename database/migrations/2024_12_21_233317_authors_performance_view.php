<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW authors_performance_report AS
                SELECT authors.name,
                       COUNT(distinct subjects.id)         as subjects_count,
                       COUNT(distinct book_author.book_id) as books_count,
                       COUNT(distinct books.publisher)     as publisher_count,
                       MIN(distinct books.created_at)      as first_publication,
                       MAX(distinct books.created_at)      as last_publication,
                       MAX(distinct books.price)           as most_expensive_price,
                       MIN(distinct books.price)           as cheapest_price,
                       GROUP_CONCAT(books.title)           as book_titles
                FROM authors
                         INNER JOIN book_author on book_author.author_id = authors.id
                         INNER JOIN book_subject on book_subject.book_id = book_author.book_id
                         INNER JOIN subjects on subjects.id = book_subject.subject_id
                         INNER JOIN books on books.id = book_author.book_id
                GROUP BY authors.name
                ORDER BY books_count DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW authors_performance_report");
    }
};
