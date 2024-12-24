<?php

namespace Database\Factories\Books;

use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->text(20),
            'publisher' => $this->faker->text(15),
            'edition' => $this->faker->numberBetween(1, 10),
            'publication_year' => $this->faker->year(),
            'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }


    public function configure(): Factory
    {
        return $this->afterCreating(function (Book $book) {
            $books = Author::factory()->count(1)->create();
            $subjects = Subject::factory()->count(1)->create();

            $book->authors()->attach($books->pluck('id'));
            $book->subjects()->attach($subjects->pluck('id'));
        });
    }
}
