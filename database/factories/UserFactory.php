<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'full_name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber('+7##########'),
            'password' => bcrypt('password'), // Здесь можно генерировать случайные пароли, но это зависит от ваших требований
            'role_id' => null, // Пока не определено
        ];
    }
}
