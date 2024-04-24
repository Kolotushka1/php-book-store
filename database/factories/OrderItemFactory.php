<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => null,
            'book_id' => null,
            'quantity' => $this->faker->numberBetween(1, 2),
            'price' => $this->faker->numberBetween(500, 5000),
        ];
    }
}
