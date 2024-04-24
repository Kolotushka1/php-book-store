<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'book_id' => null, // Пока не определено
            'user_id' => null, // Пока не определено
            'rating' => $this -> faker -> numberBetween(1, 5),
            'title' => $this -> faker->sentence,
            'review' => $this->faker->paragraph($nbSentences = 4, $variableNbSentences = true),
        ];
    }
}
