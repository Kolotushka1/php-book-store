<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition()
    {
        $genres = ['Классика', 'Наука', 'Фантастика', 'Философия', 'Биография', 'Бизнес'];
        return [
            'name' => $this->faker->randomElement($genres),
        ];
    }
}
