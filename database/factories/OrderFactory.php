<?php

namespace Database\Factories;

use App\Models\Basket;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cost' => $this->faker->numberBetween(500, 2500),
            'address' => function (array $attributes) {
                return User::find($attributes['user_id'])->address;
            },
            'date' => $this->faker->dateTimeThisMonth(),
            'status' => $this->faker->boolean(50),
        ];
    }
}
