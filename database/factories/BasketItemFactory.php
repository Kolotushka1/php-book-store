<?php
namespace Database\Factories;

use App\Models\BasketItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketItemFactory extends Factory
{
    protected $model = BasketItem::class;

    public function definition(): array
    {
        return [
            'basket_id' => null,
            'book_id' => null,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(10, 50),
        ];
    }
}
