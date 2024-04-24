<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'publisher_id' => null, // Пока не определено
            'title' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->paragraph($nbSentences = 5, $variableNbSentences = true),
            'price' => $this->faker->numberBetween(500, 2500),
            'year' => $this->faker->year(),
            'page_count' => $this->faker->numberBetween(50, 1000),
            'cover_type' => $this->faker->randomElement(['твердая', 'мягкая']),
            'edition' => $this->faker->numberBetween(1, 10),
            'age' => $this->faker->randomElement(["6+", "12+", "16+", "18+"]),
            'author_id' => null,
            'genre_id' => null,
            'image' => 'images/books/' . $this->faker->numberBetween(1, 5) . '.svg',
            'discount' => $this->faker->numberBetween(200, 350),
            'isbn' => $this->faker->unique()->isbn13,
        ];
    }
}
