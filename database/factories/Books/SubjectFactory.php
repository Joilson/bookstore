<?php

namespace Database\Factories\Books;

use App\Models\Books\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Subject>
 */
class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        return [
            'description' => $this->faker->text(20),
        ];
    }
}
